<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\loginRequest;
use App\User;
use Illuminate\Foundation\Application;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    //use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Consumer application to get the token 
     *
     * @var object
     */
    private $consumerApp;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Application $app)
    {
        $this->middleware('guest', ['except' => 'logout']);
        $this->consumerApp = $app->make('apiconsumer');

    }

    protected function guard()
    {
        return Auth::guard('guard:api');
    }

    public function login(loginRequest $request)
    {
        $email = $request->get('email');
        $password = $request->get('password');

        $user = User::where('email', $email)->first();

        //dd($user->toArray());
        if(!is_null($user)) {
            return $this->getToken('password', [
                                   'username' => $email,
                                   'password' => $password
                                    ]);     
        }
    }

    private function getToken($grantType, array $data = [])
    {
        $data = array_merge($data, [
            'client_id' => env('PASWORD_CLIENT_ID'),
            'client_secret' => env('PASSWORD_CLIENT_SECRET'),
            'grant_type' => $grantType]);

        $response = $this->consumerApp->post('oauth/token', $data);
        //dd($response);
        if (!$response->isSuccessful()) {
            abort(500, 'invalid credential');
        }

        $data = json_decode($response->getContent());

        return [
            'access_token' => $data->access_token,
            'expires_in' => $data->expires_in
            ];
    }

    public function logout()
    {
        //
    }   
}

<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\loginRequest;
use App\User;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\DB;
use Illuminate\Auth\AuthenticationException;
//use Illuminate\Validation\ValidationException;

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
     * 
     */
    private $auth;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Application $app)
    {
        //$this->middleware('guest', ['except' => 'logout']);
        //$this->middleware('auth:api', ['except' => 'login']);
        $this->consumerApp = $app->make('apiconsumer');
        $this->auth = $app->make('auth');
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

        //dd($request->get('email'));
        if(!is_null($user)) {
            return $this->getToken('password', [
                                   'username' => $email,
                                   'password' => $password
                                    ]);     
        }
        throw new AuthenticationException;

        //return response('login failed', 401)->header('Content-Type', 'application/json');
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
            //abort(500, 'invalid credential');
            throw new AuthenticationException;
        }

        $data = json_decode($response->getContent());

        return [
            'access_token' => $data->access_token,
            'expires_in' => $data->expires_in
            ];
    }

    public function logout()
    {
        $accessToken = $this->auth->user()->token();


        DB::table('oauth_refresh_tokens')
                    ->where('access_token_id', $accessToken->id)
                    ->update([
                        'revoked' => true
                    ]);


        //if($accessToken)
        $accessToken->revoke();

        //dd($this->auth->user()->token()->toArray());
        
        return response(null, 204);
        //$accessToken = ;
        //dd($this->auth->user()->token()->toArray());
    }   
}

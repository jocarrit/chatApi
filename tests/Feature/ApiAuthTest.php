<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Application;
use App;

class ApiAuthTest extends TestCase
{
    use DatabaseTransactions;

    public function test_auth_gives_token()
    {
        factory(App\User::class, 1)->create([
            'email' => 'test@testing.dev',
        ]);
        
        $user = \App\User::where('email', 'test@testing.dev')->first();

        $response = $this->appLogin($user->email, 'secret');
        
        $response->assertStatus(200)
                 ->assertJson(["access_token" => true]);
    }
    /*
    public function test_revoke_user_access_token_on_logout()
    {
        factory(App\User::class, 1)->create([
            'email' => 'test@testing.dev',
        ]);

        $user = \App\User::where('email', 'test@testing.dev')->first();

        $loginResponse = $this->appLogin($user->email, 'secret');

        $token = json_decode($loginResponse->content());
        
        //dd($token->access_token);
        $logoutResponse = $this->get('/auth/logout', [
                                    'Autorization' => 'Bearer '.$token->access_token,
                                    'X-Requested-With' => 'XMLHttpRequest'
                                   ]);

        $tokens = $user->tokens->first();
        //dd($tokens->revoked);
        $this->assertTrue($tokens->revoked);
        $logoutResponse->assertStatus(204);
    }*/

    private function appLogin($email, $password)
    {
        $loginResponse = $this->json('POST', '/auth/login', [
                     'email' => $email,
                     'password' => $password]);
        
        return $loginResponse;
    }

    public function test_invalid_credential_error() 
    {
        $user = factory(App\User::class, 1)->make([
            'email' => 'test@testing.dev',
        ]);

        $errors = [
            "message" => "Unauthenticated",
            "errors"  => [
                "name" => [
                        ""
                ]],
            "meta" => ""
        ];

        $response = $this->json('POST', '/auth/login', [
                     'email' => 'test@testing.dev',
                     'password' => 'wrong']);
        
        //$u = User::find();
        dd($response);
        $response->assertStatus(401)
                 ->assertJson(["message" => true]);
    }
}

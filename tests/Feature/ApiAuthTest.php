<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App;

class ApiAuthTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_oauth_token_given()
    {
    	$response = $this->json('POST', 'oauth/token', ['grant_type' => 'password',
    													'client_id' => '4',
    													'client_secret' => 'cG4KwT4VnpfX4NQumxPbBV8NxlIlwM6hxKTWK6SS',
    													'username' => 'vcartwright@example.org',
    													'password' => 'secret',
    													'scope' => '']);
    	$response->assertStatus(200)
    			 ->assertJson(["access_token" => true]);
        
    }

    public function test_auth_gives_token()
    {
        factory(App\User::class, 1)->create([
            'email' => 'test@testing.dev',
        ]);

        $response = $this->json('POST', '/auth/login', [
                     'email' => 'test@testing.dev',
                     'password' => 'secret']);
        
        $response->assertStatus(200)
                 ->assertJson(["access_token" => true]);
    }

    public function test_invalid_credential_error() 
    {
        $user = factory(App\User::class, 1)->make([
            'email' => 'test@testing.dev',
        ]);

        $response = $this->json('POST', '/auth/login', [
                     'email' => 'test@testing.dev',
                     'password' => 'wrong']);
        
        //$u = User::find();
        //dd($response);
        $response->assertJson(["error" => 'invalid credential']);
    }
}

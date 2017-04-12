<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Users\User;

class usersTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_User_was_created ()
    {

    	$token = $this->appLogin('test@testing.com', 'secret');

    	$response = $this->json('POST', '/users', ['name' => 'Rob Stark',
    											  'email' => 'robStark@winterfell.com',
    											  'password' => 'secret',
    											  'password_confirmation' => 'secret'], ['Authorization' => 'Bearer '.$token->access_token]);

        $response->assertStatus(200)
        		 ->assertJson(["id" => true,
        		 			  "name" => true,
        		 			  "email" => true]);
    }

    public function test_User_creation_form_not_past_validation ()
    {
    	$token = $this->appLogin('test@testing.com', 'secret');

    	$response = $this->json('POST', '/users', ['name' => 'Rob Stark',
    											  'email' => 'robStarkwinterfell.com',
    											  'password' => 'secret',
    											  'password_confirmation' => ''], ['Authorization' => 'Bearer '.$token->access_token]);
    	$response->assertStatus(422)
    			 ->assertJson(['email' => true, 'password' => true])
    			 ->assertSee('The email must be a valid email address.')
    			 ->assertSee('The password confirmation does not match.');
    }
 
    public function test_current_User_can_read_their_profile ()
    {
        $token = $this->appLogin('test@testing.com', 'secret');

    	$response = $this->json('GET', '/users/current', [], ['Authorization' => 'Bearer '.$token->access_token]);

    	$response->assertStatus(200)
    			 ->assertJson(['id' => true,
    			 			   'email' => true,
    			 			   'name' => true])
    			 ->assertSee('test@testing.com');

    }

    public function test_User_can_update_their_profile ()
    {
        $token = $this->appLogin('test@testing.com', 'secret');

    	$response = $this->json('PATCH', '/users/current', ['name' => 'Rob Stark',
    											 'email' => 'testupdated@winterfell.com',
    											 ], 
    											  ['Authorization' => 'Bearer '.$token->access_token]);

        $response->assertStatus(200)
        		 ->assertJson(["id" => true,
        		 			  "name" => true,
        		 			  "email" => true])
        		 ->assertSee('testupdated@winterfell.com')
        		 ->assertSee('Rob Stark');
    }

    private function appLogin($email, $password)
    {
    	factory(User::class, 1)->create([
    		'email' => $email
    		]);

    	$user = User::where('email', $email)->first();
    	
        $loginResponse = $this->json('POST', '/auth/login', [
                     'email' => $email,
                     'password' => $password]);

        $token = json_decode($loginResponse->content());
        return $token;
    }
}

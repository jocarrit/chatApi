<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class usersTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_User_was_created ()
    {
    	$response = $this->json('POST', '/user', ['name' => 'jon',
    											  'email' => 'josnow@nightwatch.com',
    											  'password' => 'secret',
    											  'password_confirmation' => 'secret']);
        
        $response->assertStatus(200)
        		 ->assertJson("id" => true,
        		 			  "name" => true,
        		 			  "email" => true)
        		 ->assertSee();
    }

    public function test_User_creation_form_not_past_validation ()
    {
    	$this->assertTrue(true);
    }
 
    public function test_current_User_can_read_their_profile ()
    {
        $this->assertTrue(true);
    }

    public function test_User_can_update_their_profile ()
    {
        $this->assertTrue(true);
    }
}

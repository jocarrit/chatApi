<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Users\User;
use App\Chats\Chat;
use App\Messages\Message;
use Illuminate\Support\Facades;

class chatMessagesTest extends TestCase
{
    use DatabaseTransactions;

 
    public function test_Users_can_Create_new_Chat_and_post_first_message()
    {
        // Get the token for the given user
        $token = $this->appLogin(33, 'test@testing.com', 'secret');

        $response = $this->json('POST', '/chats', ['name' => 'movies',
                                                   'message' => 'go to movies'
                                                   ], ['Authorization' => 'Bearer '.$token->access_token]);

        $response->assertStatus(200)
                 ->assertJsonFragment(['name' => 'movies'])
                 ->assertSee('go to movies');
    }

    public function test_User_can_see_list_of_all_chats_paginated()
    {  
    
      $token = $this->appLogin(33, 'test@testing.com', 'secret');
      $user = User::find(33);
      
      factory(Chat::class, 10)->states('testing')->create(['user_id' => 33]);

      $limit = 10;
      $page = 1;

      $response = $this->json('GET', '/chats?page='.$page.'&limit='.$limit, [], ['Authorization' => 'Bearer '.$token->access_token]);

      $total = Chat::all()->count();
      
      $response->assertStatus(200)
               ->assertJsonFragment(['name' => 'testing', 
                                     'users' => [
                                          'email' => 'test@testing.com', 
                                           'id' => 33, 
                                           'name' => $user->name]], 
                                     $this->getPaginationStructure($total));
    }

    public function test_User_Can_create_a_message()
    {
        $token = $this->appLogin(33, 'test@testing.com', 'secret');
        
        factory(Chat::class, 1)->states('testing')->create(['id' => 40, 'user_id' => 33]);
        
        $chat = Chat::find(33);

        $response = $this->json('POST', '/chats/'.$chat->id.'/chatmessages', [
                                                   'message' => 'go to movies'
                                                   ], [
                                                   'Authorization' => 'Bearer '.$token->access_token
                                                   ]);

        $response->assertStatus(200)
                 ->assertJsonFragment(["message" => 'go to movies'])
                 ->assertSee('movies')
                 ->assertSee('go to movies');   
    }

    public function test_User_Can_list_messages_of_specified_chat()
    {
        $token = $this->appLogin(33, 'test@testing.com', 'secret');

        factory(Chat::class, 1)->states('testing')->create(['id' => '40']);
        factory(Message::class, 3)->states('testing')->create(['chat_id' => '40']);

        $chat = Chat::find(40);

        $response = $this->json('GET', '/chats/'.$chat->id.'/chatmessages', [], [
                                                   'Authorization' => 'Bearer '.$token->access_token
                                                   ]);

        $response->assertStatus(200)
                 ->assertJsonFragment([
                                "message" => 'testing'
                                ]);   
        
    }

    private function appLogin($userId = 33, $email, $password)
    {
        factory(User::class, 1)->create([
            'id' => $userId,
            'email' => $email
            ]);

        $user = User::where('email', $email)->first();
        
        $loginResponse = $this->json('POST', '/auth/login', [
                     'email' => $email,
                     'password' => $password]);

        $token = json_decode($loginResponse->content());
        return $token;
    }

    private function getPaginationStructure($total)
    {
      return ["pagination" => ["total" => $total,
                               "count" => true,
                               "per_page" => true,
                               "current_page" => true,
                              ]];
    }

}

<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class chatMessagesTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_Users_can_Create_new_Chat_and_post_first_message()
    {
        $this->assertTrue(true);
    }

    public function test_User_can_see_list_of_all_chats_paginated()
    {
        $this->assertTrue(true);
    }

    public function test_User_Can_create_a_message()
    {
        $this->assertTrue(true);
    }

    public function test_User_Can_list_messages_of_specified_chat()
    {
        $this->assertTrue(true);
    }
}

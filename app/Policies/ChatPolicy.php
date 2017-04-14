<?php

namespace App\Policies;

use App\Users\User;
use App\Chats\Chat;
use Illuminate\Auth\Access\HandlesAuthorization;

class ChatPolicy
{
    use HandlesAuthorization;

    /**
     * Determine wheter the user can update the chat
     * 
     * @param  User
     * @param  Chat
     * @return bool
     */
    public function update(User $user, Chat $chat)
    {
        //dd($user->id);
        return dd($user->id === $chat->user_id);
    }

}

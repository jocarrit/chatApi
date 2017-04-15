<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Chats\Chat;

class chatTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Chat $chat)
    {
        return [
            'id' => $chat->id,
            'name' => $chat->name,
            'users' => $chat->users,
            'last_chat_message' => $chat->last_chat_message
        ];
    }
}

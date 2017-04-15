<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Messages\Message;

class messageTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Message $message)
    {
        return [
            'id' => $message->id,
            'chat_id' => $message->chat_id,
            'user_id' => $message->user_id,
            'message' => $message->message,
            'created_at' => $message->created_at,
            'user' => $message->user(),
        ];
    }
}

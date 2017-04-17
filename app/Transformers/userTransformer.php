<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Users\User;

class userTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(User $user)
    {
        return [
            'id' => (int)$user->id,
            'name' => $user->name,
            'email' => $user->email,
        ];
    }
}

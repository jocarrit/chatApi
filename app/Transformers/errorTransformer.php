<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use Illuminate\Contracts\Validation\Validator;

class errorTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform($message)
    {

        return [
            'message' => $message,
            'errors' => isset($message->errors) ? $message->errors : '',
            ];
    }
}

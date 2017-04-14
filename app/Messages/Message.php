<?php

namespace App\Messages;

use Illuminate\Database\Eloquent\Model;
use App\Users\User;
use App\Chats\Chat;

class Message extends Model
{
    /**
     * The attributes that are mass asignable
     * 
     * array
     */
    protected $fillable = [
    	'chat_id', 'user_id', 'message',
    ];

    protected $with = [
        'user',
    ];

    public $timestamps = false;

    /**
     * The User who posted the message
     */
    public function user()
    {
    	return $this->belongsTo(User::Class);
    }

    /**
     * The chat that where message was posted
     */
    public function chat()
    {
    	return $this->belongsTo(Chat::Class);
    }
}

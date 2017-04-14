<?php

namespace App\Chats;

use Illuminate\Database\Eloquent\Model;
use App\Users\User;
use App\Messages\Message;

class Chat extends Model
{
    /**
     * The attributes that are mass asignable
     * 
     * @var array
     */
    protected $fillable = [
    	'name',
    ];

    protected $with = [
    	'user', 'messages',
    ];

    /**
     * The users who creaated the chat
     */
    public function user()
    {
    	return $this->belongsTo(User::Class);
    }

    public function messages()
    {
    	return $this->hasMany(Message::Class);
    }


}

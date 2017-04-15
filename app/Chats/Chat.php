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

    protected $hidden = [
        'user_id', 'created_at', 'updated_at', 'user'
    ];

    protected $appends = [
        'users', 'last_chat_message',
    ];

    /**
     * The user who creaated the chat
     */
    public function user()
    {
    	return $this->belongsTo(User::Class);
    }

    public function messages()
    {
    	return $this->hasMany(Message::Class);
    }

    public function getlastChatMessageAttribute()
    {
        return $this->messages()->orderBy('id', 'desc')->first();
    }

    public function getUsersAttribute()
    {
        return $this->user;
    }




}

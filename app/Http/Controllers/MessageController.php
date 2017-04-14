<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Messages\Message;
use App\Chats\Chat;
use App\Http\Requests\messageRequest;
use \Carbon\Carbon;

class MessageController extends Controller
{
    public function store(messageRequest $request, $id, Chat $chat)
    {
    	$message = new Message;

        $message->chat_id = $id;
    	$message->message = $request->message;
    	$message->user_id = $request->user()->id;
    	$message->created_at = Carbon::now();
    	$message->save();

    	return Message::find($message->id)->message;
    }

    public function index(Request $request, $id)
    {
    	$chat = Chat::find($id);
   
    	return $chat->messages;
    	
    }
}

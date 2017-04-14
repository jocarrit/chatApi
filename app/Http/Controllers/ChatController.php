<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\chatCreateRequest;
use App\Chats\Chat;
use App\Messages\Message;
use Carbon\Carbon;

class ChatController extends Controller
{
    public function store(chatCreateRequest $request)
    {
    	$chat = new Chat;
        
    	$chat->name = $request->name;
    	$chat->user_id = $request->user()->id;
    	$chat->save();

    	$message = new Message;

    	$message->chat_id = $chat->id;
    	$message->user_id = $request->user()->id;
    	$message->message = $request->message;
    	$message->created_at = Carbon::now();
    	$message->save();

    	return Chat::find($chat->id);
    	

    }

    public function index(Request $request)
    {
    	$chats = $request->user()->chats;
    	//dd($request->limit);
    	return $chats->toArray();
    	
    }

    public function update(chatCreateRequest $request, $id, Chat $chat)
    {
    	$chat = Chat::find($id);
    	
    	$this->authorize('update-chat', $chat);
        //dd(\Gate::forUser($request->user())->allows('update-chat', $chat));

    	$chat->name = $request->name;
    	$chat->save();

    	return $chat->toArray();
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Messages\Message;
use App\Chats\Chat;
use App\Http\Requests\messageRequest;
use \Carbon\Carbon;
use League\Fractal\Resource\Collection;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use League\Fractal\Pagination\Cursor;
use App\Transformers\messageTransformer;
use \Fractal;

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

    	return Fractal::create($message, new messageTransformer())->toArray();
    }

    public function index(Request $request, $id)
    {
    	//$chat = Chat::find($id);
        $paginator = Message::where('chat_id', $id)->paginate($request->limit);
        $messages = $paginator->getCollection();
   
    	return Fractal::create()
            ->collection($messages, new messageTransformer())
            ->paginateWith(new IlluminatePaginatorAdapter($paginator))
            ->toArray();
    	
    }
}

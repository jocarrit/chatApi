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
use App\Messages\MessageRepository;

class MessageController extends Controller
{

    /**
     * the MessageRepository instance
     */
    protected $message;

    /**
     * The controller instance
     * 
     * @param MessageRepository $message 
     */
    public function __construct(MessageRepository $message)
    {
        $this->message = $message;

    }

    /**
     * Stores a new message for a given chat
     * 
     * @param  messageRequest $request 
     * @param  int            $id      the chat id
     * @param  Chat           $chat    
     * 
     * @return Json              
     */
    public function store(messageRequest $request, $id, Chat $chat)
    {
    	$message = $this->message->create($request, $id);

    	return Fractal::create($message, new messageTransformer())->toArray();
    }

    /**
     * lists messages for a given chat
     * @param  Request $request 
     * @param  int  $id      the chat id
     * 
     * @return  Json
     */
    public function index(Request $request, $id)
    {
    	//$chat = Chat::find($id);
        $paginator = $this->message->listForChat($id, $request->limit);
        $messages = $paginator->getCollection();
   
    	return Fractal::create()
            ->collection($messages, new messageTransformer())
            ->paginateWith(new IlluminatePaginatorAdapter($paginator))
            ->toArray();
    	
    }
}

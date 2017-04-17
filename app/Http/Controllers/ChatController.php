<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\chatCreateRequest;
use App\Chats\Chat;
use App\Messages\Message;
use Carbon\Carbon;
use League\Fractal\Resource\Collection;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use League\Fractal\Pagination\Cursor;
use App\Transformers\chatTransformer;
use \Fractal;
use App\Chats\ChatRepository;
use App\Messages\MessageRepository;

class ChatController extends Controller
{
    /**
     * The ChatRepository Instance
     * 
     * @var ChatRepository
     */
    protected $chat;

    /**
     * The MessageRepository Instance
     * 
     * @var MessageRepository
     */
    protected $message;

    /**
     * Controller Instance
     */
    public function __construct(ChatRepository $chat, MessageRepository $message)
    {
        $this->chat = $chat;
        $this->message = $message;
    }

    public function store(chatCreateRequest $request)
    {
    	$chat = $this->chat->create($request);
    	$message = $this->message->create($request, $chat->id);

        return Fractal::create($chat, new chatTransformer())->toArray();
    	
    }

    public function index(Request $request)
    {
        $paginator = Chat::where('user_id', $request->user()->id)->paginate($request->limit);
        $chats = $paginator->getCollection();
        
        return Fractal::create()
            ->collection($chats, new chatTransformer())
            ->paginateWith(new IlluminatePaginatorAdapter($paginator))
            ->toArray();
    }

    public function update(chatCreateRequest $request, $id, Chat $chat)
    {
    	$chat = Chat::find($id);
    	
    	$this->authorize('update-chat', $chat);
        //dd(\Gate::forUser($request->user())->allows('update-chat', $chat));

    	$chat->name = $request->name;
    	$chat->save();

    	return Fractal::create($chat, new chatTransformer())->toArray();
    }
}

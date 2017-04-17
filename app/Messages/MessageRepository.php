<?php	

namespace App\Messages;

use App\Messages\Message;
use Illuminate\Http\Request;
use \Carbon\Carbon;

/**
* Database Eloquent Repository
*/
class MessageRepository
{
	
	/**
	 * create a new message
	 * @param  Request $request 
	 * @param  int  $chatId  
	 * @return App/Chats/Chat Chat Model
	 */
	public function create(Request $request, $chatId)
	{
		$message = new Message;

        $message->chat_id = $chatId;
    	$message->message = $request->message;
    	$message->user_id = $request->user()->id;
    	$message->created_at = Carbon::now();
    	$message->save();

    	return $message;
	}

	/**
	 * List of messages of a given chat
	 * @param  int $chatId 
	 * @param  int $limit  limit pagination
	 * @return Collection  
	 */
	public function listForChat($chatId, $limit)
	{
		return Message::where('chat_id', $chatId)->paginate($limit);
	}
}
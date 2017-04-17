<?php 

namespace App\Chats;

use Illuminate\Http\Request;
use \Carbon\Carbon;
use App\Chats\Chat;

/**
* Database Eloquent Repository
* 
*/
class ChatRepository
{
	
	/**
	 * Create new Chat
	 * @param  Request $request 
	 * @return App\Chats\Chat           
	 */
	public function create(Request $request)
	{
		$chat = new Chat;
        
    	$chat->name = $request->name;
    	$chat->user_id = $request->user()->id;
    	$chat->save();	

    	return $chat;
	}

	/**
	 * Chat list for a User
	 * @param  int $userId 
	 * @param  int $limit  pagination limit
	 * @return Collection         
	 */
	public function listForUser($userId, $limit)
	{
		return Chat::where('user_id', $userid)->paginate($limit);
	}	

	/**
	 * Update Chat
	 * @param  Request $request 
	 * @return App\Chats\Chat
	 */
	public function update(Request $request)
	{
		$chat = Chat::find($id);

		$chat->name = $request->name;
    	$chat->save();

    	return $chat;
	}
}
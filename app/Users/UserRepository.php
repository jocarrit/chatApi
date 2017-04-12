<?php 
namespace App\Users;

use Illuminate\Http\Request;

class UserRepository
{

	public function current(Request $request)
	{
		return User::where('email', $request->user()->email)->first();
	}

	public function create(Request $request)
	{
		$user = new User;

    	$user->name = $request->name;
    	$user->password = bcrypt($request->password);
    	$user->email = $request->email;

    	$user->save();

    	return $user->where('email', $request->email)->first();

	}

	public function update(Request $request)
	{
		$user = User::find($request->user()->id);
		
		$user->email = $request->email;
		$user->name = $request->name;
		//dd($request->email);
		$user->save();
		//dd($user);
		return $user;
	}
	
}
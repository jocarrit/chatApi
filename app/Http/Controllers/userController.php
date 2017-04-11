<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\userRequest;
use App\User;

class userController extends Controller
{
    public function store(userRequest $request)
    {
    	$user = new User;

    	$user->name = $request->name;
    	$user->password = bcrypt($request->password);
    	$user->email = $request->email;

    	$user->save();

    	return $user->where('email', $request->email)->first();
    }
}

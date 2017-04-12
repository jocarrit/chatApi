<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\userRequest;
use App\Http\Requests\userUpdateRequest;
use App\Users\User;
use App\Users\UserRepository;

class userController extends Controller
{
	/**
	 * UserRepository Instance
	 *
	 * @var UserRepository
	 */
	protected $users;

	/**
	 * Controller Instance
	 *
	 * @param UserRepository $users
	 * @return void
	 */
	public function __construct(UserRepository $users)
	{
		$this->users = $users;
	}
    
    /**
     * Stores new users
     *
     * @param userRequest
     * @return User
     */
    public function store(userRequest $request)
    {
    	return $this->users->create($request);
    }

    /**
     * Shows user profile
     *
     * @param Request
     * @return Collection
     */
    public function index(Request $request)
    {
    	return $this->users->current($request);
    }

    public function update(userUpdateRequest $request)
    {
    	return $this->users->update($request);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\userRequest;
use App\Http\Requests\userUpdateRequest;
use App\Users\User;
use App\Users\UserRepository;
use App\Transformers\userTransformer;
use League\Fractal\Resource\Collection;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use League\Fractal\Pagination\Cursor;
use \Fractal;

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
    	$user = $this->users->create($request);

        return Fractal::create($user, new userTransformer())->toArray();
    }

    /**
     * Shows user profile
     *
     * @param Request
     * @return Collection
     */
    public function show(Request $request)
    {
    	$user = $this->users->current($request);

        return Fractal::create($user, new userTransformer())
        ->toArray();
    }

    public function update(userUpdateRequest $request)
    {
        $user = $this->users->update($request);

        return Fractal::create($user, new userTransformer())->toArray();
    }
}

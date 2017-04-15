<?php

use Illuminate\Http\Request;

Route::group(['middleware' => 'auth:api'], function () {

	Route::post('/users', 'userController@store');

	Route::patch('/users/current', 'userController@update');

	Route::get('/users/current', 'userController@index');

	Route::post('/chats', 'chatController@store');

	Route::get('/chats', 'chatController@index');

	Route::post('chats/{id}', 'chatController@update');

	Route::post('chats/{id}/chatmessages', 'messageController@store');

	Route::get('chats/{id}/chatmessages', 'messageController@index');

});




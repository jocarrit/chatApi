<?php

use Illuminate\Http\Request;

Route::group(['middleware' => 'auth:api'], function () {

	Route::post('users', 'userController@store');

	Route::get('/users/current', 'userController@index');

});




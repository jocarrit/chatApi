<?php


Route::get('/', function () {
    return view('welcome');
});

Route::post('/auth/login', 'Auth\LoginController@login');
Route::middleware('auth:api')->get('/auth/logout', 'Auth\LoginController@logout');



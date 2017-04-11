<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

//Auth::routes();
Route::post('/auth/login', 'Auth\LoginController@login');
Route::middleware('auth:api')->get('/auth/logout', 'Auth\LoginController@logout');

Route::get('/home', 'HomeController@index');

<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
    // return view('index');
});

// //LoginController
// Route::group(array('prefix' => 'login'), function(){
//     Route::get('/', 'LoginController@show');
//     Route::post('/', 'LoginController@login');
//     Route::get('/logout', 'LoginController@logout');
// });

Route::auth();

Route::get('/home', 'HomeController@index');

Route::get('/dashboard', 'PushController@index');

Route::group(array('prefix' => 'dashboard'), function(){
    Route::get('/', 'PushController@index');
    Route::get('/{post_id}', 'PushController@detail');
});
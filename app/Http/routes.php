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

// Route::get('/dashboard', 'PushController@index');

Route::group(array('prefix' => 'dashboard'), function(){
    Route::get('/', 'ReportController@index');
    Route::get('/{push_id}', 'ReportController@detail');
});

Route::group(array('prefix' => 'push'), function(){
    Route::get('/', 'PushController@index');
    Route::post('/add', 'PushController@add');
    Route::get('/get/{push_id}', 'PushController@get_push');
    Route::get('/aaa', 'PushController@send_push');
});

Route::get('/reg/{client_id}', 'RegController@reg');
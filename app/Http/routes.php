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

//Route::auth();

Route::get('login', 'Auth\AuthController@showLoginForm');
Route::post('login', 'Auth\AuthController@login');
Route::get('logout', 'Auth\AuthController@logout');

// Registration Routes...
Route::get('register', 'Auth\AuthController@showRegistrationForm');
Route::post('register', 'Auth\AuthController@register');

// Password Reset Routes...
Route::get('password/reset/{token?}', 'Auth\PasswordController@showResetForm');
Route::post('password/email', 'Auth\PasswordController@sendResetLinkEmail');
Route::post('password/reset', 'Auth\PasswordController@reset');

Route::get('/home', 'HomeController@index');

// 報表
Route::group(['prefix' => 'dashboard', 'middleware'=>'auth'], function(){
    Route::get('/', 'ReportController@index');
    Route::get('/{push_id}', 'ReportController@detail');
});

// 新增推播
Route::group(['prefix' => 'push', 'middleware'=>'auth'], function(){
    Route::get('/', 'PushController@index');
    Route::post('/add', 'PushController@add');
    Route::get('/test', 'PushController@send_push');
});

// 新增 client_id 訂閱
Route::get('/reg/{client_id}', ['middleware' => 'cors','uses' => 'RegController@reg']);

// 取消 client_id 訂閱
Route::get('/unsub/{client_id}', ['middleware' => 'cors','uses' => 'RegController@unsubscribe']);

// 取得 push_id 推播
Route::get('/push/get/{push_id}', 'PushController@get_push');

// 取得最新一筆推播內容
Route::get('/push/latest', ['middleware' => 'cors','uses' => 'PushController@latest']);
//Route::get('/reg/{client_id}', 'RegController@reg');

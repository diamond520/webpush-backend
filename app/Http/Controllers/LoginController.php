<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator as Validator;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests;
use App\Models\Pusher;
use Auth;
use View;

class LoginController extends Controller
{
    public function show()
    {
        return View::make('auth/login');
        // return "abc";
    }
    public function login()
    {
        $input = Input::all();
        $rules = [ 'email'=>'required|email',
                  'password'=>'required' ];
        $validator = Validator::make($input, $rules);

        if ($validator->passes()) {
            // $attempt = Auth::attempt([
            //     'email' => $input['email'],
            //     'password' => $input['password']
            // ]);
            // if ($attempt) {
            //     return Redirect::intended('welcome');
            // }
            if (Auth::attempt(['email' => $input['email'], 'password' => $input['password']])) {
                // 認證通過...
                return redirect()->intended('welcome');
            }
            return Redirect::to('login')
                    ->withErrors(['fail'=>'account or password is wrong!']);
        }

        //fails
        return Redirect::to('login')
                    ->withErrors($validator)
                    ->withInput(Input::except('password'));

    }
    public function logout()
    {
        Auth::logout();
        return Redirect::to('login');
    }
}

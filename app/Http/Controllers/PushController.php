<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests;
use App\Models\Push;
use Auth;
use Validator;
use View;

class PushController extends Controller
{

    public function index()
    {
        return View::make('push.index');
    }

    public function add(Request $request)
    {
        if (! $request->isMethod('post')) {
            // is not post redirect to url: /
            return ;
        }
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:255',
            'body' => 'required|max:255',
            'icon' => 'url',
            'url' => 'url',
        ]);
        if ($validator->fails()) {
            return redirect('/push')
                    ->withErrors($validator)
                    ->withInput();
        }

        $push = new Push;
        $push->title = $request->input('title');
        $push->body = $request->input('body');
        $push->icon = $request->input('icon');
        $push->action = $request->input('url');
        $push->pusher_id = Auth::user()->id;

        $push->save();

        return Redirect::to('/dashboard/'.$push->id);
    }
}

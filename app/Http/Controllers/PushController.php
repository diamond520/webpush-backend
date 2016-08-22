<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\Push;
use Auth;

class PushController extends Controller
{

    public function index()
    {
    	// return "1223";
    	$pusher = Auth::user();
    	$pushes = Push::where('pusher_id', $pusher->id)->get();
    	// return $pushes;
        return view('dashboard', ['pushes' => $pushes]);
    }
    public function detail($push_id)
    {
        return $push_id;
    }
}

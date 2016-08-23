<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\Push;
use Auth;

class ReportController extends Controller
{

    public function index()
    {
    	$pusher = Auth::user();
    	$pushes = Push::where('pusher_id', $pusher->id)
    					->orderBy('created_at', 'desc')
    					->get();
    	// return $pushes;
        return view('dashboard.index', ['pushes' => $pushes]);
    }

    public function detail($push_id)
    {
    	$push = Push::where('id', $push_id)->first();
        // return $push;
        return view('dashboard.report', ['push' => $push]);
    }
}

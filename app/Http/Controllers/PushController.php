<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests;
use App\Models\Push;
use App\Models\WebUser;
use Auth;
use DB;
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

        $this->send_push();

        return Redirect::to('/dashboard/'.$push->id);
    }

    public function get_push($push_id)
    {
        $validator = Validator::make(array('push_id' => $push_id) , [
            'push_id' => 'required|unique:mysql.push_list,id'
        ]);
        if ($validator->fails()) {
            // invalid push_id, return default push msg
            return "fail";
        }
        $push = Push::where('pusher_id', $push_id)
                        ->first();
        return $push;
    }

    public function send_push()
    {
        $apiKey = "AIzaSyAnqDQhjNQiXO_PdO6-uU5uFH6reH6Cims";

        $users = DB::table('web_user')
                        ->select(DB::raw('registation_id as id'))
                        ->where('state', '=', 1);
        $count = $users->count();
        $ids = $users->get();

        $sendMax = 1000;  
        $sendLoop = ceil($count / $sendMax);

        for($i = 0 ; $i < $sendLoop ; $i++)
        {
            // 打包一千組 gcm id
            $regID = array();
            for($j=0 ; $j < $sendMax ; $j++)
            {
                $index = ($i * $sendMax) + $j;
                if($index < $count)
                {   
                    $row = $ids[$index];
                    array_push($regID, $row->id);
                }
                else
                {
                    break;
                }
            }

            $this->send_push($regID);
        }
    }

    public function send_push_notification($registation_id) 
    {
        // fcm endpoint
        $url = 'https://fcm.googleapis.com/fcm/send';
        
        $registation_ids = array(
            $registation_id
        );
        
        $data = "testing data";

        $fields = array(
            'registration_ids' => $registation_ids,
            'data' => $data,
            'time_to_live' => 60
        );
 
        $headers = array(
            'Authorization: key= AIzaSyAnqDQhjNQiXO_PdO6-uU5uFH6reH6Cims',
            'Content-Type: application/json'
        );

        $ch = curl_init();
 
        curl_setopt($ch, CURLOPT_URL, $url);
 
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
 
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }
 
        curl_close($ch);
    }

}

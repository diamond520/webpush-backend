<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests;
use App\Models\Push;
use App\Models\WebUser;
use App\Jobs\SendPush;
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

		$this->send_push($push->id);
        // $job = (new SendPush());
        // $this->dispatch($job);

		// return 'done';
		return Redirect::to('/dashboard/'.$push->id);
	}

	public function get_push($push_id)
	{
		$push = Push::where('pusher_id', $push_id)
						->first();
		return $push;
	}

	public function latest() 
	{
		$push = Push::orderBy('id', 'desc')
						->first();
		return $push;
	}

	public function send_push($push_id)
	{
		// $t1 = microtime(true);
		$apiKey = "AIzaSyAnqDQhjNQiXO_PdO6-uU5uFH6reH6Cims";
		$users = DB::table('web_user')
						->select(DB::raw('registation_id as id'))
						->where('state', '=', 1);
		$count = $users->count();
		$ids = $users->get();

		$sendMax = 1000;  
		$sendLoop = ceil($count / $sendMax);

		// $t2 = microtime(true);

		for($i = 0 ; $i < $sendLoop ; $i++)
		{
			$regID = [];
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
			$del_id = [];
			$del = $this->send_push_notification($regID, $push_id);
			
			foreach ($del as $key => $val) {
				array_push($del_id, $ids[$sendMax*$i+$val]->id);
			}

			if (count($del_id)>0)
			{
				$this->del_gcm_reg_id($del_id);
			}
		}
		// $t3 = microtime(true);
		// $ss1 = $t2 - $t1;
		// $ss2 = $t3 - $t2;
		// $ss = $t3-$t1;
		// echo "s1: $t1<br/>";
		// echo "s2: $t2<br/>";
		// echo "s3: $t3<br/>";
		// echo "ss1: $ss1<br/>";
		// echo "ss2: $ss2<br/>";
		// echo "ss: $ss<br/>";
	}

	public function del_gcm_reg_id($del_id) 
	{
		// print_r($del_id);
		WebUser::whereIn('registation_id', $del_id)->delete();
	}

	public function send_push_notification($registation_id, $push_id) 
	{
		// fcm endpoint
		$url = 'https://fcm.googleapis.com/fcm/send';
		
		$registation_ids = $registation_id;
		
		$data = 'data';

		$fields = array(
			'registration_ids' => $registation_ids,
			'data' => array("data" => $data),
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

		$response = curl_exec($ch);
		$response = json_decode($response);
		$result = $response->results;
		$unregcnt = count($result);

		$del = [];

		foreach ($result as $key => $value) {
			// echo $key;
			if ( isset($value->error) ) {
				array_push($del, $key);
			}
		}
		$push = Push::find($push_id);
		$push->success += $response->success;
		$push->failure += $response->failure;
		$push->save();

		curl_close($ch);
		return $del;
	}
}

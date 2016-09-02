<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\Push;
use App\Models\WebUser;
use DB;


class SendPush extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->id = $id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
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
            $del = $this->send_push_notification($regID);
            
            foreach ($del as $key => $val) {
                array_push($del_id, $ids[$sendMax*$i+$val]->id);
            }

            if (count($del_id)>0)
            {
                $this->del_gcm_reg_id($del_id);
            }
        }
    }

    public function send_push_notification($registation_id) 
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
        $result = json_decode($response)->results;
        $unregcnt = count($result);

        $del = [];

        foreach ($result as $key => $value) {
            // echo $key;
            if ( isset($value->error) ) {
                array_push($del, $key);
            }
        }
        
        curl_close($ch);
        return $del;
    }

    public function del_gcm_reg_id($del_id) 
    {
        // print_r($del_id);
        WebUser::whereIn('registation_id', $del_id)->delete();
    }
}

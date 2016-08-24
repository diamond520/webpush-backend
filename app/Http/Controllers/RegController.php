<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\WebUser;
use Validator;

class RegController extends Controller
{
    // reg gcm id
    public function reg($client_id)
    {
        $validator = Validator::make(array('id' => $client_id) , [
            'id' => 'required|unique:mysql.web_user,registation_id'
        ]);
        if ($validator->fails()) {
            return "fail";
        }
        $user = new WebUser;
        $user->registation_id = $client_id;
        $user->state = 1;
        $user->save();

        return $user;
    }
}

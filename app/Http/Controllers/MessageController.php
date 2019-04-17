<?php

namespace App\Http\Controllers;

use App\Mail\Welcome;
use App\Locksmith;
use App\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function index(){
    	Message::send("+639074239571", "oh yeah!");
    	// $msg = new Message;
    	// $msg->send("+639074239571", "oh yeah!");
		// $account_sid = 'AC418da46149b758eb8c6672a8220e74d5'; 
		// $auth_token = '2520d19d4c22e532585da4b5db3b34e2'; 
		
		// $client = new Client($account_sid, $auth_token); 
		 
		// $messages = $client
		//   ->messages->create("+639074239571", array( 
		//         'From' => "+13304224368",  
		//         'Body' => "matan is love",      
		// ));
		// // $messages = $client->api->v2010->accounts->create("+639074239571", array( 
		// //         'From' => "+13304224368",  
		// //         'Body' => "mata is love",      
		// // ));
		// return "send?";
    }

    public function resend(){
    	$ls = Locksmith::find(session('ls_id'));

        Message::send($ls->phone, 
            "Onlinekeycodes: Your level up request confirmation code: ".$ls->vcode, session('ls_id'));
        
        return response()->json(array(
            'msg' => 'Resent!', 
            'number' => $ls->phone
        ), 200);
    }
}

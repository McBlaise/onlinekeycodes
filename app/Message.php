<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Twilio\Rest\Client;

class Message extends Model
{
    protected $guarded = [];

    public static function send($num, $msg, $id){
        $ls = Locksmith::find($id);

        if($ls->phone_status != "verified" && $ls->phone_status != "unverified"){
            return response()->json(['msg'=>'No phone'], 200);
        }

        $num = str_replace(' ', '', $num);
        if(strlen($num) < 11){
            $num = "+1".$num;
        }
        else{
            $num = "+".$num;
        }

		$client = new Client(env("TWILIO_ACCOUNT"), env("TWILIO_AUTH_KEY")); 
		 
		$messages = $client
		  ->messages->create($num, array( 
		        'From' => "+12025597320",  
		        'Body' => $msg,      
		));

    }

}

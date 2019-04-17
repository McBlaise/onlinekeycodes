<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Crypt;

use Illuminate\Http\Request;
use App\Mail\Results;
use App\Locksmith;
use App\Process;
use App\Message;

class ProcessController extends Controller
{
    public function index(){
    	$processes = Process::where('status', '!=', 'processing')->latest()->get();
        foreach ($processes as $process) {
            if($process->transaction_id != 0){
                //transactionssss
                $process->p_details = $process->transaction()->locksmith();
                $process->t_details = $process->transaction();

                if($process->t_details->level == 1){
                    $rank = "Silver";
                }else if($process->t_details->level == 2){
                    $rank = "Gold";
                }else{
                    $rank = "Platinum";
                }

                $process->t_details->level = $rank;
                $process->t_details->serial_num = Crypt::decryptString($process->t_details->serial_num);
                $process->t_details->card_num = Crypt::decryptString($process->t_details->card_num);
            }
            else{
                //sign up and level up locksmith
                $process->p_details = $process->locksmith();

                if($process->p_details->level == 1){
                    $rank = "Silver";
                }else if($process->p_details->level == 2){
                    $rank = "Gold";
                }else{
                    $rank = "Platinum";
                }

                $process->p_details->package = $rank;
                $process->t_details = "";
            }
        }
        return response()->json(array('msg'=>'Success', 'processes'=>$processes));
    }

    public function store(Request $request){
    	$request = $request->json()->all();

    	$t_id = $request['t_id'] ?: 0;
    	$ls_id = $request['ls_id'] ?: 0; 

    	if($t_id != 0){
            $process = Process::where('status', 'processing')->where('transaction_id', $t_id)->count();
    		$type = 'Order';
    	}else{
            $process = Process::where('status', 'processing')->where('locksmith_id', $ls_id)->count();
    		$locksmith = Locksmith::find($ls_id);
    		if($locksmith->status == 'pending'){
                $type = 'signup';
            }else{
                $type = $locksmith->status;
            }
    	}

    	if($process > 0){
    		return response()->json(array('msg'=>'Already processing!'));
    	}

    	$process = new Process;
    	$process->user_id = session('id');
    	$process->transaction_id = $t_id;
    	$process->locksmith_id = $ls_id;
    	$process->type = $type;
    	$process->status = 'processing';
        $process->remarks = 'none';
    	//store processes
    	if($process->save()){
    		return response()->json(array('msg'=>'processing...'));
    	}
    }

    public function cancel(Request $request){
        $request = $request->json()->all();

        $t_id = $request['t_id'] ?: 0;
        $ls_id = $request['ls_id'] ?: 0; 

        $process = Process::where('status', 'processing')->where('transaction_id', $t_id)->where('locksmith_id', $ls_id)->first();
        if(empty($process)){
            return response()->json(array('msg'=>'Noting to delete!'), 200);
        }

        if($process->delete()){
            return response()->json(array('msg'=>'Process Canceled!'), 200);
        }
        return response()->json(array('msg'=>'Something went wrong'), 200);
    }

    public function refresh(){
    	//refresh all processing
        $processes = Process::where('status', 'processing')->get();
        foreach ($processes as $process) {
            $process->delete();
        }
        return response()->json(['msg'=>'Processes Refreshed']);

    }

    public function update(Request $request, Process $process){
    	//update processes remarks only
        $request = $request->json()->all();
        $process->remarks = $request['remarks'];

        if($process->save()){

            if($process->transaction() != null){
                $transaction = $process->transaction();
                $locksmith = $process->transaction()->locksmith();

                if($locksmith->phone_status == "verified" && $locksmith->preference != "email" && $locksmith->preference != "none"){
                    Message::send($locksmith->phone, 
                    "Onlinekeycodes:  Results have been update for your keycode request. Results: ".$process->remarks, $locksmith->id);
                }

                if($locksmith->preference != "sms" && $locksmith->preference != "none"){
                    \Mail::to($locksmith)->send(new Results($locksmith, $transaction, $process));
                }
            }

            return response()->json(['msg'=>'Success!']);
        }
    }

}

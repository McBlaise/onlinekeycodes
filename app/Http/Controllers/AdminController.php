<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Mail\Welcome;
use App\Mail\Results;
use App\Mail\Upgrade;
use App\Transaction;
use App\Locksmith;
use App\Process;
use App\Message;
use App\Charges;
use App\File;
use DateTime;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $request = $request->json()->all();
        $user = User::where('user', $request['user'])->first();

        if(!$user) {
            return response()->json(['status'=>'error', 'msg'=>'User not found'], 200);
        }

        if(!$request['password'] == $user->password){
            return response()->json(['status'=>'error', 'msg'=>'Invalid Credentials'], 200);
        }

        if($user->status == 'pending'){
            return response()->json(['status'=>'error', 'msg'=>'Not yet approved'], 200);
        }

        session(['id' => $user->id, 'ls_id' => $user->locksmith()->id]);
        return response()->json(['status'=>'success'], 200);    
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function everything()
    {
        $users = Locksmith::where('status', 'maxlevel')->oldest()->get();
        $transactions = DB::table('transactions')
            ->join('locksmiths', 'transactions.locksmith_id', '=', 'locksmiths.id')
            ->select('transactions.*', 'locksmiths.firstname', 'locksmiths.middlename', 'locksmiths.lastname')
            ->where('transactions.status', 'pending')
            ->latest()
            ->get();

        foreach ($users as $user){
            // $process = Process::where('status', 'processing')->where('locksmith_id', $user->id)->count();
            // if($process > 0){
            //     $user->processing = true;
            // }else{
            //     $user->processing = false;
            // }
            // $user->files = $user->files();
            // $user->card = $user->card();
            $process = Process::where('status', 'processing')->where('locksmith_id', $user->id)->count();
            $user->type = 'Upgrade to platinum';
            if($process > 0){
                $user->processing = true;
            }else{
                $user->processing = false;
            }
            $user->files = File::where('uploader', $user->id)->where('transaction_id', NULL)->get();
            $user->card = $user->card();
            $user->card->serial_num = Crypt::decryptString($user->card->serial_num);
            $user->card->card_num = Crypt::decryptString($user->card->card_num);
        }

        foreach ($transactions as $transaction){
            // $process = Process::where('status', 'processing')->where('transaction_id', $transaction->id)->count();
            // if($process > 0){
            //     $transaction->processing = true;
            // }else{
            //     $transaction->processing = false;
            // }
            $process = Process::where('status', 'processing')->where('transaction_id', $transaction->id)->count();
            $transaction->type = "Request for key code";
            $transaction->serial_num = Crypt::decryptString($transaction->serial_num);
            $transaction->card_num = Crypt::decryptString($transaction->card_num);
            $transaction->files = File::where('transaction_id', $transaction->id)->get();
            if($process > 0){
                $transaction->processing = true;
            }else{
                $transaction->processing = false;
            }
        }

        $combined = array_merge(json_decode(json_encode($users), true), json_decode(json_encode($transactions), true));

        usort($combined, function ($a, $b) {
            $dateA = new DateTime($a['created_at']);
            $dateB = new DateTime($b['created_at']);
            // ascending ordering, use `<=` for descending
            return $dateA >= $dateB;
        });

        // dd($users);
        // return view('test.show', compact('users'));
        // return response()->json(array('msg'=>'success', 'locksmiths'=> $users, 'transactions'=> $transactions), 200);
        return response()->json(array('msg'=>'success', 'list'=> $combined), 200);
    }

    public function approve(Request $request){
        //approve processes
        $request = $request->json()->all();
        $t_id = $request['t_id'] ?: 0;
        $ls_id = $request['ls_id'] ?: 0; 

        $process = Process::where('status', 'processing')->where('transaction_id', $t_id)->where('locksmith_id', $ls_id)->first();

        if($t_id != 0){
            $process->status = 'done';
            $transaction = $process->transaction();
            $transaction->status = 'done';
            $process->remarks = $request['remarks'];

            if($process->save() && $transaction->save()){

                $files = File::where('transaction_id', $transaction->id)->get();
                if($files->count() > 0){
                    foreach($files as $file){
                        $filename = $file->filename.'.'.$file->extension;
                        if($file->delete()){
                            unlink(public_path().'/storage/files/'.$filename);
                        }
                    }
                }

                $locksmith = $transaction->locksmith();
                if($locksmith->phone_status == "verified" && $locksmith->preference != "email" && $locksmith->preference != "none"){
                    Message::send($locksmith->phone, 
                    "Onlinekeycodes:  Your keycode request is approved! Results: ".$process->remarks, $locksmith->id);
                }

                if($locksmith->preference != "sms" && $locksmith->preference != "none"){
                    \Mail::to($locksmith)->send(new Results($locksmith, $transaction, $process));
                }

                return response()->json(array('msg'=>'Transaction Finished!'), 200);
            }
        }
        else{
            $locksmith = Locksmith::find($request['ls_id']);
            if($locksmith->status == 'maxlevel'){
                $locksmith->package = 3;
            }

            if($locksmith->status == 'pending'){
                // \Mail::to($locksmith)->send(new Welcome);
            }

            $process->status = 'done';
            $process->remarks = $request['remarks'];
            $locksmith->status = 'approved';

            if($locksmith->save() && $process->save()){
                //unlink files
                $files = File::where('uploader', $locksmith->id)->where('transaction_id', NULL)->get();
                if($files->count() > 0){
                    foreach($files as $file){
                        $filename = $file->filename.'.'.$file->extension;
                        if($file->delete()){
                            unlink(public_path().'/storage/files/'.$filename);
                        }
                    }
                }
                
                if($locksmith->phone_status == "verified" && $locksmith->preference != "email"){
                    Message::send($locksmith->phone, 
                    "Onlinekeycodes:  Your max-level request is approved!", $locksmith->id);
                }

                if($locksmith->preference != "sms" && $locksmith->preference != "none"){
                    \Mail::to($locksmith)->send(new Upgrade($locksmith, $process));
                }

                return response()->json(array('msg'=>'success'), 200);
            }
            return response()->json(array('msg'=>'failed'), 200);
        }
    }

    public function denied(Request $request){
        $request = $request->json()->all();

        $t_id = $request['t_id'] ?: 0;
        $ls_id = $request['ls_id'] ?: 0; 

        $process = Process::where('status', 'processing')->where('transaction_id', $t_id)->where('locksmith_id', $ls_id)->first();

        if($t_id != 0){
            //its an order
            $process->status = 'rejected';
            $transaction = $process->transaction();
            $transaction->status = 'rejected';
            $process->remarks = $request['remarks'];

            if($process->save() && $transaction->save()){
                
                $files = File::where('transaction_id', $transaction->id)->get();
                if($files->count() > 0){
                    foreach($files as $file){
                        $filename = $file->filename.'.'.$file->extension;
                        if($file->delete()){
                            unlink(public_path().'/storage/files/'.$filename);
                        }
                    }
                }

                $locksmith = $transaction->locksmith();
                if($locksmith->phone_status == "verified" && $locksmith->preference != "email" && $locksmith->preference != "none"){
                    Message::send($locksmith->phone, 
                    "Onlinekeycodes:  Your keycode request is denied! Results: ".$process->remarks, $locksmith->id);
                }

                if($locksmith->preference != "sms" && $locksmith->preference != "none"){
                    \Mail::to($locksmith)->send(new Results($locksmith, $transaction, $process));
                }

                return response()->json(array('msg'=>'Transaction Rejected!'), 200);
            }

        }else{
            //its a signup or levelup
            $locksmith = Locksmith::find($request['ls_id']);
            $process->status = 'rejected';
            $process->remarks = $request['remarks'];
            if($locksmith->status == 'maxlevel'){
                $locksmith->status = 'approved';

                if($process->save() && $locksmith->save()){
                    //unlink files
                    $files = File::where('uploader', $locksmith->id)->where('transaction_id', NULL)->get();
                    if($files->count() > 0){

                        foreach($files as $file){
                            $filename = $file->filename.'.'.$file->extension;

                            if($file->delete()){
                                unlink(public_path().'/storage/files/'.$filename);
                            }
                        }
                    }

                    if($locksmith->phone_status == "verified" && $locksmith->preference != "email"){
                        Message::send($locksmith->phone, 
                        "Onlinekeycodes:  Your max-level request is declined! Results: ".$process->remarks, $locksmith->id);
                    }

                    \Mail::to($locksmith)->send(new Upgrade($locksmith, $process));
                
                   return response()->json(array('msg'=>'Levelup rejected!'), 200);     
                }
            }
            else{
                if($process->delete() && $locksmith->save()){
                    return response()->json(array('msg'=>'Signup rejected!'), 200);    
                }
            }
            
        }

        return response()->json(array('msg'=>'Process failed!'), 200);
    }


    public function levelUp(){
        //get all who wants to level up
        $users = Locksmith::where('status', 'levelup')->oldest()->get();
        return response()->json(array('msg'=>'success','locksmiths' => $users), 200);
    }

    public function pending(){
        //get all who wants to register
        $users = Locksmith::where('status', 'pending')->oldest()->get();
        return response()->json(array('msg'=>'success','locksmiths' => $users), 200);
    }

    public function appeal(){
        //get all except approved
        $users = Locksmith::where('status', '!=', 'approved')->oldest()->get();
        return response()->json(array('msg'=>'success', 'locksmiths'=> $users), 200);
    }

    public function locksmiths(){
        $users = Locksmith::where('status', 'approved')->get();
        if(!empty($users)){
            foreach ($users as $user) {
                $user->card = $user->card();
                $user->credentials = $user->credentials();
            }
        }
        return response()->json(array('msg'=>'success', 'locksmiths'=>$users), 200);
    }

    public function edit(Locksmith $locksmith, Request $request){
        $request = $request->json()->all();
        if(Locksmith::where('email', $request['email'])
            ->whereNotIn('id', [$locksmith->id])
            ->count() > 0){
                return response()->json(array('msg' => 'Email already taken'), 200);
        }
        $locksmith->email = $request['email'];
        if($locksmith->save()){
            return response()->json(array('msg'=>'success'), 200);
        }else{
            return "something went wrong";
        }
    }

    public function delete(Locksmith $locksmith){
        if($locksmith->delete() 
            && $locksmith->card()->delete() 
            && $locksmith->credentials()->delete()){
            return response()->json(array('msg'=>'success'), 200);
        }
        return response()->json(array('msg'=>'something went wrong'), 200);
    }

    public function signupCharge(Request $request){

        $request = $request->json()->all();

        $charge = Charges::where('type', 'signup');

        if($charge->count()>0){

            $charge = $charge->first();
            $charge->amount = $request['price'];
            $charge->remarks = $request['remarks'];
            if($request['isActivated']){
                
                $charge->is_active  = "true";
            
            }
            else{

                $charge->is_active  = "false";

            }

            $charge->save(); 
        }
        else{

            $charge = new Charges;
            $charge->type = 'signup';
            $charge->amount = $request['price'];
            $charge->remarks = $request['remarks'];
            if($request['isActivated']){
                
                $charge->is_active  = "true";
            
            }
            else{

                $charge->is_active  = "false";

            }
            
            $charge->save();

        }

    }

    public function signupChargeDetails(){

        return response()->json(array('msg'=>'success', 'settings' => Charges::where('type', 'signup')->first()), 200);

    }

}

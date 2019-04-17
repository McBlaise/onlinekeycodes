<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\Locksmith;
use Illuminate\Support\Facades\Crypt;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $request = $request->json()->all();
        $user = User::where('user', $request['user'])->first();

        if(!$user) {
            return response()->json(['status'=>'error', 'msg'=>'User not found'], 200);
        }

        if(!Hash::check($request['password'], $user->password)){
            return response()->json(['status'=>'error', 'msg'=>'Invalid Credentials'], 200);
        }

        if($user->locksmith_id == 0){
            $ls_id = 0;
            $type = 'admin';
        }
        else{
            $ls_id = $user->locksmith()->id;
            $type = 'cleint';

            if($user->locksmith()->status == 'pending'){
            return response()->json(['status'=>'error', 'msg'=>'Not yet approved'], 200);
            }
        }

        session(['id' => $user->id, 'ls_id' => $ls_id]);
        return response()->json(['status'=>'success', 'type'=>$type], 200);
    }

    public function adminRegister(Request $request){
        $user = new User;
        $user->user = $request['user'];
        $user->password = app('hash')->make($request['password']);
        $user->locksmith_id = 0;

        if($user->save()){
            return response()->json(array('msg' => 'success'), 200);
        }
    }

    public function currentUser(){

        $credentials = User::find(session('id'));
        $locksmith = $credentials->locksmith();
        $card = $locksmith->card();
        
        if($card->serial_num != null){
            $card->serial_num = Crypt::decryptString($card->serial_num);
        }

        if($card->card_num != null){
            $card->card_num = Crypt::decryptString($card->card_num);
        }

        return response()->json(['status'=>'success', 'p_details' => $locksmith,
         'credentials' => $credentials, 'cards' => $card], 200);
    }

    public function admin(){
        $id = session('id');
        $admin = User::where('id', $id)->get();
        return response()->json(['admin'=>$admin], 200);
    }

    public function checkSession(){
        
        if(session()->has('id') && session()->has('ls_id')){
            if(User::find(session('id'))->locksmith_id == 0){
                $type = 'admin';
            }else{
                $type = 'cleint';
            }

            return response()->json(['msg'=>'true', 'type'=>$type], 200);
        }
        return response()->json(['msg'=>'false'], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function changePass(Request $request){
        $request = $request->json()->all();

        $user = User::find(session('id'));

        if (!Hash::check($request['old_password'], $user->password)){
            return response()->json(['status'=>'error', 'msg' => 'Invalid Password'], 200);
        }

        $user->password = app('hash')->make($request['new_password']);
        if($user->save()){
            return response()->json(['msg' => 'successfully update!'], 200);
        }

    }

    public function destroy(){
        if(session()->has('id') || session()->has('ls_id')){
            session()->forget('id');
            session()->forget('ls_id');
            return redirect('/');
        }
    }

    public function update(Request $request){
        $admin = User::find(session('id'))->first();

        if(User::where('user', $request['user'])
            ->whereNotIn('id', [$admin->id])
            ->count() > 0){
                return response()->json(array('msg' => 'Username already taken'), 200);
        }

        $admin->user = $request['user'];
        $admin->password = app('hash')->make($request['password']);
        if($admin->save()){
            return response()->json(['msg'=>'successfully updated'], 200);
        }
        return response()->json(['msg'=>'db error'], 200);
    }

}

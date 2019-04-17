<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Card;
use App\Locksmith;
use Illuminate\Support\Facades\Crypt;

class CardController extends Controller
{
    
    public function store(Request $request){
        $request = $request->json()->all();

		$card = new Card;

    	$card->locksmith_id = $request['locksmith_id'];
    	$card->card_num = $request['card_num'];
    	$card->serial_num = $request['serial_num'];
        $card->status = 0;

        if($card->save()){
        	return response()->json(array('msg' => 'success'), 200);
        }
        else{
        	return response()->json(array('msg' => 'error'), 200);
        }
    }

    public function destroy(Card $card){
    	if($card->delete()){
    		return response()->json(array('msg' => 'success'), 200);
    	}
    	else{
    		return response()->json(array('msg' => 'error'), 200);
    	}
    }

    public function card(Locksmith $locksmith){
    	$card = $locksmith->card();
    	if($card){
    		return response()->json(array('data' => $card, 'msg' => 'success'), 200);
    	}
    	else{
    		return response()->json(array('msg' => 'error'), 200);
    	}
    }

    public function edit(Request $request){
        $request = $request->json()->all();

        $card = Card::where('locksmith_id', session('ls_id'))->first();
        $cryptedNum = Crypt::encryptString($request['card_num']);
        $card->card_num = $cryptedNum;
        $cryptedSerial = Crypt::encryptString($request['serial_num']);
        $card->serial_num = $cryptedSerial;
        $card->b_add = $request['b_add'];
        $card->exp_date = $request['exp_date'];

        if($card->save()){
            return response()->json(array('msg' => 'Updated!'), 200);
        }
        return response()->json(array('msg' => 'Update failed!'), 200); 
    }
}

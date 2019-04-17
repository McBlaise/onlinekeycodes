<?php

namespace App\Http\Controllers;

use App\Events\Verify;
use App\Events\Remove;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use App\Mail\Welcome;
use App\Mail\PasswordReset;
use App\Locksmith;
use App\Message;
use App\User;
use App\Card;
use App\Charges;
use App\Http\Resources\Locksmith as LocksmithResource;
use net\authorize\api\contract\v1 as AnetAPI;
use net\authorize\api\controller as AnetController;
use Illuminate\Support\Facades\Crypt;

class LocksmithController extends Controller
{
    
	public function index(){

		$locksmiths = Locksmith::get();
        foreach($locksmiths as $locksmith){
            $locksmith->card = $locksmith->card();
            $locksmith->card->card_num = Crypt::decryptString($locksmith->card->card_num);
            $locksmith->card->serial_num = Crypt::decryptString($locksmith->card->serial_num);
        }
		return LocksmithResource::collection($locksmiths);
	}

	public function show(Locksmith $locksmith){
		$card = $locksmith->card();
        $card->card_num = Crypt::decryptString($card->card_num);
        $card->serial_num = Crypt::decryptString($card->serial_num);
		$credentials = $locksmith->credentials();
		return response()->json(array('msg' => 'success', 'card' => $card, 'credentials' => $credentials, 'p_information' => $locksmith), 200);
	}

    public function create(Request $request){

        $request = $request->json()->all();

    	$locksmith = new Locksmith;
    	$user = new User;
    	$card = new Card;

        if (!filter_var($request['email'], FILTER_VALIDATE_EMAIL)) {
          return response()->json(array('msg' => 'Email Invalid!'), 200);
        }

        if(Locksmith::where('email', $request['email'])->count() > 0){
            return response()->json(array('msg' => 'Email already exists'), 200);
        }
        
        if(User::where('user', $request['user'])->count() > 0){
            return response()->json(array('msg' => 'Username already exists'), 200);
        }

    	$locksmith->firstname = $request['firstname'];
    	$locksmith->lastname = $request['lastname'];
    	$locksmith->middlename = $request['middlename'] ?: " ";
    	$locksmith->email = $request['email'];
    	$locksmith->company = $request['company'];
        $locksmith->company_add = $request['company_add'];
    	$locksmith->status = 'pending';
    	$locksmith->package = 1;
        $locksmith->ls_id = 0;
        $locksmith->password = '';
        $locksmith->preference = 'email'; 
        $locksmith->vcode = str_random(10);      

    	if($locksmith->save()) {
    		//get last inserted id
    		$id = $locksmith->id;

	    	$user->user = $request['user'];
	    	$user->password = app('hash')->make($request['password']);
	    	$user->locksmith_id = $id;

	    	$card->locksmith_id = $id;
            $cryptedNum = Crypt::encryptString($request['card_num']);
            $card->card_num = $cryptedNum;
            $cryptedSerial = Crypt::encryptString($request['serial_num']);
            $card->serial_num = $cryptedSerial;
            $card->exp_date = $request['exp_date'];
	    	$card->b_add = $request['b_add'];
            $card->status = 1;

	    	if($card->save() && $user->save()){
                // \Mail::to($locksmith)->send(new Welcome($locksmith));
                // dd($locksmith);
    			return response()->json(array('msg' => 'success'), 200);
	    	}
            else{
                $ls = Locksmith::find($id);
                $ls->delete();
            }
    	}
    }

    public function update(Request $request){
        $request = $request->json()->all();
        //locksmith id
        $ls_id = session('ls_id');
        //check for email and user duplicate from other users except the current user request
        if(Locksmith::where('email', $request['email'])
            ->whereNotIn('id', [$ls_id])
            ->count() > 0){
                return response()->json(array('msg' => 'Email already taken'), 200);
        }

        $preference = $request['preference'];
        // if($request['sms'] && !$request['email']){
        //     $preference = 'sms';
        // }else if(!$request['sms'] && $request['email']){
        //     $preference = 'email';
        // }else{
        //     $preference = 'both';
        // }

        $locksmith = Locksmith::find($ls_id);
        //check if phone is changed
        if($locksmith->phone != $request['phone']){
            //the phone number is changed then set new vcode
            $vcode = rand(10000, 99999);
            $locksmith->vcode = $vcode;
            $locksmith->phone_status = 'unverified';
            $preference = "email";
            Message::send($request['phone'], 
                "Onlinekeycodes: Your phone verification code: ".$vcode, session('ls_id'));
        }

        // if(User::where('user', $request['user'])
        //     ->whereNotIn('locksmith_id', [$ls_id])
        //     ->count() > 0){
        //         return response()->json(array('msg' => 'Username already taken'), 200);
        // }
        
        //credentials ['user', 'password']
        $credentials = User::where('locksmith_id', $ls_id)->first();

        $locksmith->firstname = $request['firstname'];
        $locksmith->lastname = $request['lastname'];
        $locksmith->middlename = $request['middlename'];
        $locksmith->email = $request['email'];
        $locksmith->company = $request['company'];
        $locksmith->company_add = $request['company_add'];
        $locksmith->ls_id = $request['ls_id'] ?: 0;
        $locksmith->password = $request['password'] ?: '';
        $locksmith->phone = $request['phone'];
        $locksmith->preference = $preference; 

        $credentials->user = $request['user'];
        if($request['upassword'] != 'none'){
            $credentials->password = app('hash')->make($request['upassword']);
        }

        if($locksmith->save() && $credentials->save()){
            return response()->json(array('msg' => 'Updated!', 'preference' => $preference), 200);
        }
        return response()->json(array('msg' => 'Update failed!'), 200); 
    }

    public function getLevel(){
        $ls = Locksmith::find(session('ls_id'));
        $level = $ls->package;
        $stat = $ls->status;
        $pstat = 'none';
        
        if($ls->phone != null || $ls->phone != " " || $ls->phone != ""){
            $pstat = $ls->phone_status;
        }

        $shit = false;
        if($ls->ls_id != 0 && $ls->password != ''){
            $shit = true;
        }
        return response()->json(
        array(
            'msg' => 'success', 
            'level' => $level, 
            'status' => $stat, 
            'shit' => $shit, 
            'phone' => $pstat
        ), 200);
    }

    public function verify(Request $request){
        $ls = Locksmith::where('id', $request['id'])->where('vcode', $request['vcode']);
        $charge = Charges::where('type', 'signup');

        if($charge->count()>0){

            $charge = $charge->first();

            if($charge->is_active == 'true'){

                $result = $this->chargeSignup($request, $charge->amount); 
                return redirect($result);

            }
            else{

                // dd($ls);
                if($ls->first() == null){
                    $ls = Locksmith::where('id', $request['id']);
                    if($ls->first() == null){
                        return redirect('/?msg=unauthorized');
                    }
                    event(new Remove($ls->first()));
                    return redirect('/?msg=error');
                }
                event(new Verify($ls->first()));
                return redirect('/?msg=success');

            }

        }else{

            // dd($ls);
            if($ls->first() == null){
                $ls = Locksmith::where('id', $request['id']);
                if($ls->first() == null){
                    return redirect('/?msg=unauthorized');
                }
                event(new Remove($ls->first()));
                return redirect('/?msg=error');
            }
            event(new Verify($ls->first()));
            return redirect('/?msg=success');

        }
        
    }

    public function SMSverify(Request $request){
        $request = $request->json()->all();
        $ls_id = session('ls_id');
        
        $ls = Locksmith::where('id', $ls_id)->where('vcode', $request['vcode']);

        if($ls->first() == null){
            $ls = Locksmith::where('id', $ls_id);
            if($ls->first() == null){
                return response()->json(array('msg'=>'unauthorized'), 200);
            }
            return response()->json(array('msg'=>'wrong code'), 200);
        }

        $ls = $ls->first();
        
        if($ls->status == 'levelup'){
            $ls->package = 2;
            $ls->status = 'approved';
        }

        $ls->phone_status = 'verified';
        $ls->vcode = '';

        if($ls->save()){
                return response()->json(array('msg'=>'success'), 200);
        }
        return response()->json(array('msg'=>'db error'), 200);
    }

    public function passwordReset(Request $request){
        $request = $request->json()->all();
        $email = $request['email'];

        $ls = Locksmith::where('email', $email);
        if($ls->count() == 0){
            return response()->json(['msg'=>'invalid email']);
        }

        $user = $ls->first()->credentials();
        $temporary = str_random(5);
        $user->password = app('hash')->make($temporary);

        if($user->save()){
            \Mail::to($ls->first())->send(new PasswordReset($ls->first(), $temporary));

            return response()->json(['msg' => 'success', 'email' => $ls->first()->email]);
        }
    }

    public function chargeSignup($request, $amount){
        
        $ls = Locksmith::find($request['id']);
        $card = Card::where('locksmith_id', $request['id'])->first(); 
        $t_type = 'subscription fee';
        $cardSerial = Crypt::decryptString($card->serial_num);
        $cardNum = Crypt::decryptString($card->card_num);

        $merchantAuthentication = new AnetAPI\MerchantAuthenticationType();
        $merchantAuthentication->setName(env("ANET_LOGIN_KEY"));
        $merchantAuthentication->setTransactionKey(env("ANET_TRANSACTION_KEY"));

        // $request = new AnetAPI\CreateTransactionRequest();
        // $request->setMerchantAuthentication($merchantAuthentication);
        
        $refId = 'resf' . time();

        // Create the payment data for a credit card
        $creditCard = new AnetAPI\CreditCardType(); 
        $creditCard->setCardNumber($cardNum);
        $creditCard->setExpirationDate($card->exp_date);
        $creditCard->setCardCode(strval($cardSerial));
        // Add the payment data to a paymentType object
        $paymentOne = new AnetAPI\PaymentType();
        $paymentOne->setCreditCard($creditCard);
        // Create order information
        $order = new AnetAPI\OrderType();
        $order->setInvoiceNumber($refId);
        $order->setDescription($t_type); //transaction type
        // Set the customer's Bill To address
        $customerAddress = new AnetAPI\CustomerAddressType();
        $customerAddress->setFirstName($ls->firstname);
        $customerAddress->setLastName($ls->lastname);
        // Set the customer's identifying information
        $customerData = new AnetAPI\CustomerDataType();
        $customerData->setType("individual");
        $customerData->setId(strval($ls->id)); //user id diri
        $customerData->setEmail($ls->email); //email address diri
        // Add values for transaction settings
        $duplicateWindowSetting = new AnetAPI\SettingType();
        $duplicateWindowSetting->setSettingName("duplicateWindow");
        $duplicateWindowSetting->setSettingValue("60");
        // Create a TransactionRequestType object and add the previous objects to it
        $transactionRequestType = new AnetAPI\TransactionRequestType();
        $transactionRequestType->setTransactionType("authCaptureTransaction");
        $transactionRequestType->setAmount($amount); //total bayronun
        $transactionRequestType->setOrder($order);
        $transactionRequestType->setPayment($paymentOne);
        $transactionRequestType->setBillTo($customerAddress);
        $transactionRequestType->setCustomer($customerData); 
        $transactionRequestType->addToTransactionSettings($duplicateWindowSetting);
        $requestAuth = new AnetAPI\CreateTransactionRequest();
        $requestAuth->setMerchantAuthentication($merchantAuthentication);
        $requestAuth->setRefId($refId); 
        $requestAuth->setTransactionRequest($transactionRequestType);
        // Create the controller and get the response
        $controller = new AnetController\CreateTransactionController($requestAuth); 
        $response = $controller->executeWithApiResponse(\net\authorize\api\constants\ANetEnvironment::PRODUCTION);
        // $response = $controller->executeWithApiResponse(\net\authorize\api\constants\ANetEnvironment::SANDBOX);

        if ($response != null) { 
            // Check to see if the API request was successfully received and acted upon
            if ($response->getMessages()->getResultCode() == "Ok") {  
                // Since the API request was successful, look for a transaction response
                // and parse it to display the results of authorizing the card
                $tresponse = $response->getTransactionResponse();
                
                if ($tresponse != null && $tresponse->getMessages() != null) { 

                    event (new Verify($ls->first()));
                    return '/?msg=successP';

                } else {
                    if ($tresponse->getErrors() != null) {
                        event(new Remove($ls->first()));
                        return '/?msg=failedP';

                    }
                }
                // Or, print errors if the API request wasn't successful
            } else {
                $tresponse = $response->getTransactionResponse();

                if($response->getTransactionResponse()->getErrors()[0]->getErrorText() == "The credit card number is invalid."){
                    event(new Remove($ls->first()));
                    return '/?msg=invalidP';

                }
                else{

                    if ($tresponse != null && $tresponse->getErrors() != null) {
                        event(new Remove($ls->first()));
                        return '/?msg=failedP';
                        // return response()->json(array('msg' => 'Transaction Failed 2!', 'error' => $tresponse->getErrors()[0]->getErrorText()), 200);
                    } else {
                        event(new Remove($ls->first()));
                        return '/?msg=failedP';
                        // return response()->json(array('msg' => 'Transaction Failed 3!', 'error' => $response->getMessages()->getMessage()[0]->getText()), 200);
                    } 

                }

            }
        } else {
            event(new Remove($ls->first()));
            return '/?msg=failedP';
            // return response()->json(array('msg' => 'Transaction Failed 4!', 'error' => "no response"), 200);
        }

    }

}

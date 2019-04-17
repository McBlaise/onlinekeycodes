<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Transaction;
use App\Locksmith;
use App\Message;
use App\Process;
use App\Car;
use App\Http\Resources\Locksmith as LocksmithResource;
use net\authorize\api\contract\v1 as AnetAPI;
use net\authorize\api\controller as AnetController;
use Illuminate\Support\Facades\Crypt;

class TransactionController extends Controller
{

	public function index(){
		$transactions = DB::table('transactions')
            ->join('locksmiths', 'transactions.locksmith_id', '=', 'locksmiths.id')
            ->select('transactions.*', 'locksmiths.firstname', 'locksmiths.middlename', 'locksmiths.lastname')
            ->get();

		return response()->json(array('transactions' => $transactions, 'msg' => 'success'), 200);
	}

    public function show(Transaction $transaction){
        return response()->json(array('transaction'=>$transaction),200);
    } 
    
    public function create(Request $request){
        // dd(env("ANET_LOGIN_KEY"));
        $request = $request->json()->all();
        $ls_id = session('ls_id');
        $ls = Locksmith::where('id', $ls_id);
        $car = Car::find($request['car_id']);
        $card = $ls->first()->card();
        $amount = $car->price;

        if($amount != 0){
            if($card->serial_num == null || $card->card_num == null || $card->exp_date == null){
                return response()->json(array('msg' => 'no card'), 200);
            }
    
            $cardSerial = Crypt::decryptString($card->serial_num);
            $cardNum = Crypt::decryptString($card->card_num);
        }
        //decrypt card numbers

        $t_type = 'keycode payment';
        $ls = $ls->first();
        $level = $ls->package;
        $amount = 0;
        //because if its free, then no need for authorize . net! 
        if($amount != 0){

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
            $transactionRequestType->setAmount(strval($car->price)); //total bayronun
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
            // dd($response);
            
            if ($response != null) { 
                // Check to see if the API request was successfully received and acted upon
                if ($response->getMessages()->getResultCode() == "Ok") { 
                    // Since the API request was successful, look for a transaction response
                    // and parse it to display the results of authorizing the card
                    $tresponse = $response->getTransactionResponse();
                    
                    if ($tresponse != null && $tresponse->getMessages() != null) {
                        
                        if($car == null){
                            return response()->json(array('msg' => 'no cars'), 200);
                        }

                        $transaction = new Transaction;

                        $transaction->locksmith_id = $ls_id;
                        $transaction->level = $level;
                        $transaction->make = $car->make;
                        $transaction->price = $car->price;

                        $transaction->card_num = $card->card_num;
                        $transaction->serial_num = $card->serial_num;
                        $transaction->exp_date = $card->exp_date;
                        $transaction->b_add = $card->b_add;

                        $transaction->vin = $request['vin'];
                        $transaction->ls_id = $ls->ls_id ?: 0;
                        $transaction->password = $ls->password ?: 0;
                        //status = ['pending', 'processing', 'complete']
                        $transaction->status = 'pending';

                        if($transaction->save()){
                         return response()->json(array('msg' => 'success', 'car' => $car, 't_id' => $transaction->id), 200);
                        }

                    } else {
                        if ($tresponse->getErrors() != null) {

                            return response()->json(array('msg' => 'failed'), 200);
                            // return response()->json(array('msg' => 'Transaction Failed!', 'error' => $tresponse->getErrors()[0]->getErrorText()), 200);
                        }
                    }
                    // Or, print errors if the API request wasn't successful
                } else {
                    $tresponse = $response->getTransactionResponse();
                    if($response->getTransactionResponse()->getErrors()[0]->getErrorText() == "The credit card number is invalid."){

                        return response()->json(array('msg' => 'invalid'), 200);

                    }
                    else{

                        if ($tresponse != null && $tresponse->getErrors() != null) {

                            return response()->json(array('msg' => 'failed'), 200);
                            // return response()->json(array('msg' => 'Transaction Failed 2!', 'error' => $tresponse->getErrors()[0]->getErrorText()), 200);
                        } else {
                            return response()->json(array('msg' => 'failed'), 200);
                            // return response()->json(array('msg' => 'Transaction Failed 3!', 'error' => $response->getMessages()->getMessage()[0]->getText()), 200);
                        } 

                    }

                }
            } else {
                
                return response()->json(array('msg' => 'failed'), 200);
                // return response()->json(array('msg' => 'Transaction Failed 4!', 'error' => "no response"), 200);
            }
        }
        else{
            $transaction = new Transaction;

            $transaction->locksmith_id = $ls_id;
            $transaction->level = $level;
            $transaction->make = $car->make;
            $transaction->price = $car->price;

            $transaction->card_num = $card->card_num;
            $transaction->serial_num = $card->serial_num;
            $transaction->exp_date = $card->exp_date;
            $transaction->b_add = $card->b_add;

            $transaction->vin = $request['vin'];
            $transaction->ls_id = $ls->ls_id ?: 0;
            $transaction->password = $ls->password ?: 0;
            //status = ['pending', 'processing', 'complete']
            $transaction->status = 'pending';

            if($transaction->save()){
             return response()->json(array('msg' => 'success', 'car' => $car, 't_id' => $transaction->id), 200);
            }
        }
    }

    public function history(){
        $locksmith = Locksmith::find(session('ls_id'));
        $history = $locksmith->transactions();
        $t = 0;

        if(empty($history)){
            return response()->json(array('msg' => 'nothing to show'), 200);  
        }else{
            foreach ($history as $shit) {
                if($shit->status == 'pending'){
                }else{
                    $t++;
                    $shit->remarks = $shit->process()->remarks;    
                }
            }
            if($t == 0){
                return response()->json(array('msg' => 'nothing to show'), 200); 
            }
            return response()->json(array('msg' => 'success', 'history' => $history), 200);  
        }
    }

    public function upgrade(){
        $history = Process::where('type', '!=', "Order")->where('locksmith_id', session('ls_id'));
    }

    public function levelUp(Request $request){
        $request = $request->json()->all();
        //cardnumber, exp, serial, levelup, amount
        $vcode = rand(10000, 99999);
        $ls = Locksmith::find(session('ls_id'));
   
        $ls->status = "levelup";
        $ls->ls_id = $request['ls_id'];
        $ls->phone = trim($request['phone']);
        $ls->phone_status = 'unverified';
        $ls->password = $request['password'];
        $ls->vcode = $vcode;

        if($ls->save()){
            //send message with the $vcode
            Message::send($request['phone'], 
                "Onlinekeycodes: Your level up request confirmation code: ".$vcode, session('ls_id'));
            
            return response()->json(array(
                'msg' => 'Transaction Complete!', 
                'number' => $request['phone']
            ), 200);
        }else{
            return response()->json(['msg'=>'db error']);
        }
        // $locksmith = Locksmith::find(session('ls_id'));
        // //levelup indicates a request from locksmith to level up
        // $locksmith->status = "levelup";
        // if($locksmith->save()){
        //     return response()->json(array('msg' => 'success'));
        // }
    }

    public function processing(Transaction $transaction){
        session(['t_id' => $transaction->id, 'status' => $transaction->status]);
        $transaction->status = 'processing';
        if($transaction->save()){
            return response()->json(array('msg'=>'processing'));
        }
    }

    public function revert(){
        if(!session()->has('t_id')){
            return response()->json(array('msg'=>'no processing session'));
        }
        $transaction = Transaction::find(session('t_id'));
        $transaction->status = session('status');
        if($transaction->save()){
            session()->forget(['t_id', 'status']);
            return response()->json(array('msg'=>'revert status'));
        }
    }

}

<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/', function () { 
    return view('index');
});

//see welcome email
// Route::get('/email', function() {
// 	return view('emails.result');
// });

//test page
// Route::get('/test', function(){
// 	return view('test.test');
// });

// Route::get('/deletefile/{file}', 'FileController@destroy');

// Route::get('/crypt', 'FileController@crypt');
//test email
// Route::get('/send', 'MessageController@index');
//['fistname', 'lastname', 'middlename', 'email', 'company', 'company_add', 'user', 'passowrd', 'card_num', 'serial_num']
Route::post('/signup', 'LocksmithController@create');
//verify admin
Route::get('/verify', 'LocksmithController@verify');
//sign up admin
// Route::post('/register/admin', 'UserController@adminRegister');
//signup 'user' and 'password'
Route::post('/login', 'UserController@index');
//store card with ['locksmith_id', 'card_num', 'serial_num', 'status = 1'] 1 is active, 0 is inactive
// Route::post('/card/create', 'CardController@create');
//check for users if login
Route::get('/check', 'UserController@checkSession');
//get all cars
Route::get('/cars', 'CarController@index');
Route::get('/car/{level}', 'CarController@carByLevel');
//change password ['old_password', 'new_password']
Route::post('/changePass', 'UserController@changePass');
//--------------------------------------------------------
Route::post('/resetPass', 'LocksmithController@passwordReset');
Route::get('/settings/signupChargeDetails', 'AdminController@signupChargeDetails'); // get signup setting
//without session, it will return json with msg => 'no active session'
Route::middleware(['check'])->group(function () {
	//destroy session or Logout
	Route::get('/logout', 'UserController@destroy');
	
	//check if ! locksmith session is given, return msg = 'required locksmith session'
    Route::middleware(['locksmith'])->group(function(){
    	//get current user
		Route::get('/currentUser', 'UserController@currentUser');
		//update personal information
		Route::post('/update', 'LocksmithController@update');
    	Route::post('/card/edit', 'CardController@edit');
	    Route::post('/purchase', 'TransactionController@create');
    	Route::get('/locksmith/level', 'LocksmithController@getLevel');
    	/*request with: 
		['car_id', 
		'vin', 
		'sms' = boolean,
		'email' = boolean, 
		'ls_id'(nullable default to 0), 
		'password'(nullable default to 0)]*/
		// Route::post('/purchase', 'TransactionController@create');
		//get locksmith transaction history
		Route::get('/locksmith/history', 'TransactionController@history'); 
		Route::get('/locksmith/upgrade', 'TransactionController@upgrade'); 
		// Route::get('/locksmith/level', 'LocksmithController@getLevel'); //get locksmith level
		//level up request from locksmith to 2
		Route::post('/locksmith/levelup', 'TransactionController@levelUp');
		//upload file level up to 3
		Route::post('/locksmith/maxlevel', 'FileController@upload');
		//download file
		Route::get('/download/{file}', 'FileController@download');
		//verify sms
		Route::post('/sms/verify', 'LocksmithController@SMSverify');
		//same method as admin but different route
		Route::post('/user/update', 'UserController@update');
		Route::get('/resend', 'MessageController@resend');
		Route::post('/requirements', 'FileController@requirements');
    });

	//check if ! admin session is given, return msg = 'requires admin session'
    Route::middleware(['admin'])->group(function(){
    	//get current admin
    	Route::get('/user/admin', 'UserController@admin');
		//store car with ['make', 'level', 'price']
		Route::post('/car/create', 'CarController@create');
    	//get all information of a user, give locksmith id as parameter
		Route::get('/user/{locksmith}', 'LocksmithController@show');
		//get card from a locksmith
		Route::get('/card/{locksmith}', 'CardController@card');
		//get all locksmiths
		Route::get('/users', 'LocksmithController@index');
		//------------------------------------------------------------------
		//get all locksmith except approved
		// Route::get('/locksmith/request', 'AdminController@appeal');
		//get all transactions
		// Route::get('/transactions', 'TransactionController@index');
		//combine top
		Route::get('/transaction/request', 'AdminController@everything');
		//------------------------------------------------------------------
		//only locksmith id is needed ['ls_id'] as request...approves pending,
		//and also approves level 1 request for levelup at the same time changing 1 to 2
		Route::post('/request/approval', 'AdminController@approve');
		Route::post('/request/rejection', 'AdminController@denied');
		// ------------------------------------------------------------------------------
		//get specific transaction
		// Route::get('/transaction/{transaction}', 'TransactionController@show');
		//processing purchase stores a session for transaction id and transaction status
		// Route::post('/processing/{transaction}', 'TransactionController@processing');
		//revert if process not complete revert back to previous status
		Route::post('/process/cancel', 'ProcessController@cancel');
		//store processes
		Route::post('/processing', 'ProcessController@store');
		Route::get('/processes', 'ProcessController@index');
		Route::post('/process/{process}/update', 'ProcessController@update');
		//-------------------------------------------------------------------
		Route::get('/locksmith/approved', 'AdminController@locksmiths');
		Route::post('/edit/{locksmith}', 'AdminController@edit');
		Route::post('/delete/{locksmith}', 'AdminController@delete');
		//-------------------------------------------------------------------
		Route::post('/admin/update', 'UserController@update');
		//--------------------------------------------------------------
		Route::post('/editCar/{car}', 'CarController@edit');
		Route::post('/deleteCar/{car}', 'CarController@delete');
		//--------------------------------------------------------------
		Route::post('/process/refresh', 'ProcessController@refresh');
		// activate signup charging
		Route::post('/settings/signupCharge', 'AdminController@signupCharge');
		
    });
});
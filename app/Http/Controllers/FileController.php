<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\File;
use App\Locksmith;
use App\Transaction;
use Illuminate\Support\Facades\Crypt;

class FileController extends Controller
{
    public function upload(Request $request){
    	// $request = $request->json()->all();
    	// dd(request('file'));
		// foreach(request('file') as $key => $val){
		// 	$rules['file.'.$key] = 'required|max:2048';
		// }
        //$this->validate(request(), $rules);

    	foreach(request('fileD') as $file){
    		//file name with extension
    		$filenameWithExt = $file->getClientOriginalName();
    		//get filename
    		$filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
    		//get just ext
    		$extension = $file->getClientOriginalExtension();
    		//file name to store
    		$fileNameToStore = $filename.'_'.time();
    		//upload file
    		$path = $file->storeAs('public/files', $fileNameToStore.'.'.$extension);

    		File::create([
    			'uploader' => session('ls_id'),
    			'filename' => $fileNameToStore,
    			'extension' => $extension
    		]);
    	}

        foreach(request('fileB') as $file){
            //file name with extension
            $filenameWithExt = $file->getClientOriginalName();
            //get filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            //get just ext
            $extension = $file->getClientOriginalExtension();
            //file name to store
            $fileNameToStore = $filename.'_'.time();
            //upload file
            $path = $file->storeAs('public/files', $fileNameToStore.'.'.$extension);

            File::create([
                'uploader' => session('ls_id'),
                'filename' => $fileNameToStore,
                'extension' => $extension
            ]);
        }

        if(request('fileL') != NULL){

            foreach(request('fileL') as $file){
                //file name with extension
                $filenameWithExt = $file->getClientOriginalName();
                //get filename
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                //get just ext
                $extension = $file->getClientOriginalExtension();
                //file name to store
                $fileNameToStore = $filename.'_'.time();
                //upload file
                $path = $file->storeAs('public/files', $fileNameToStore.'.'.$extension);

                File::create([
                    'uploader' => session('ls_id'),
                    'filename' => $fileNameToStore,
                    'extension' => $extension
                ]);
            }

        }

        if($path){
            //change status to maxlevel
            $ls = Locksmith::find(session('ls_id'));
            if($ls->company_add == null || $ls->company_add == "" || $ls->company_add == " "){
                $ls->company_add = $request['state'];
            }
            $ls->vcode = $request['einssn'];
            $ls->status = 'maxlevel';

            $ls->save();
    		// session()->flash('message', 'File/Files Uploaded!');
        	return response()->json(array('msg'=>'Successfully Uploaded!'), 200);
        }
        else{

            // session()->flash('message', 'Looks like something went wrong!');
            return response()->json(array('msg'=>'Error Upload'), 200);
        }
    }

	public function download($file_name) {
		// $file_path = public_path('storage/files/'.$file_name);
		// return response()->download($file_path);
		// dd(storage_path("app/public/".$file_name));
		return response()->download(public_path("files/".$file_name));
	}

    public function crypt(Request $request) {
        $crypted = Crypt::encryptString($request['string']);
        $decrypted = Crypt::decryptString($crypted);
        return response()->json(['string' => $request['string'], 'encrypted' => $crypted, 'decrypted' => $decrypted,'charCount' => strlen($crypted)]);
    }

    public function destroy(File $file){
        // dd($file->filename.'.'.$file->extension);
        $filez = $file->filename.'.'.$file->extension;
        // dd($file);
        if($file->delete()){
            unlink(public_path().'/storage/files/'.$filez);
        }
    }

    public function requirements(Request $request){
        // dd(request['filez']);
        foreach(request('filez') as $file){
            //file name with extension
            $filenameWithExt = $file->getClientOriginalName();
            //get filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            //get just ext
            $extension = $file->getClientOriginalExtension();
            //file name to store
            $fileNameToStore = $filename.'_'.time();
            //upload file
            $path = $file->storeAs('public/files', $fileNameToStore.'.'.$extension);

            File::create([
                'uploader' => session('ls_id'),
                'transaction_id' => $request['t_id'],
                'filename' => $fileNameToStore,
                'extension' => $extension
            ]);
        }

        $t = Transaction::find($request['t_id']);
        $t->extra = $request['detailz'];
        if($t->save()){
            return response()->json(['msg'=>"success"], 200);
        }
        else{
            return response()->json(['msg'=>"error"], 200);
        }
    }
}

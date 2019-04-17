<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Car;
use App\File;

class CarController extends Controller
{
    public function index(){
    	$cars = Car::orderBy('level', 'asc')->orderBy('make', 'asc')->get();
    	return response()->json(array('cars' => $cars, 'msg' => 'success'), 200);
    }

    public function create(Request $request){

        $car = new Car;

        $car->make = $request['make'];
        $car->level = $request['level'];
        $car->price = $request['price'];
        $car->remarks = $request['remarks'];
        $car->year = $request['year'];
        $car->time = $request['time'];
        $car->docs = $request['docs'];
        
        if(!is_string(request('file')[0])){
            $file = request('file')[0]; 
            //file name with extension
            try{
                $filenameWithExt = $file->getClientOriginalName();
            }catch(\Throwable $e){
                return response()->json(['msg' => 'error', 'status' => 'File too large!']);
            }
            //get filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            //get just ext
            $extension = $file->getClientOriginalExtension();
            //file name to store
            $fileNameToStore = $filename.'_'.time();
            //upload file
            $car->filename = $fileNameToStore.'.'.$extension;

            try{
                if($file->move('logo/', $fileNameToStore.'.'.$extension)){
                    if($car->save()){
                        return response()->json(array('msg' => 'success'), 200);
                    }
                }
            }catch (\Exception $e){
                return response()->json(['msg' => 'error', 'status' => 'Invalid file type']);
            }
            

        }
        else{

                return response()->json(array('msg' => 'error', 'status' => 'no image'), 200);
        }
        
        return response()->json(array('msg' => 'error', 'status' => 'try again later'), 200);
    }

    public function carByLevel($level){
    	$cars = Car::where('level', '<=', $level)->orderBy('make', 'desc')->get();
    	return response()->json(array('msg' => 'success', 'cars' => $cars), 200);
    }

    public function searchCar($string){
        $results = Car::where('name', 'like', "$string%")->get();
        return response()->json(array('msg' => 'success', 'cars' => $results), 200);
    }

    public function edit(Car $car, Request $request){
        
        $car->make = $request['make'];
        $car->level = $request['level'];
        $car->price = $request['price'];
        $car->remarks = $request['remarks'];
        $car->year = $request['year'];
        $car->time = $request['time'];
        $car->docs = $request['docs'];

        if(!is_string(request('file')[0])){

            $file = request('file')[0]; 

            try{
                $filenameWithExt = $file->getClientOriginalName();
            }catch(\Throwable $e){
                return response()->json(['msg' => 'error', 'status' => 'File too large!']);
            }
            //get filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            //get just ext
            $extension = $file->getClientOriginalExtension();
            //file name to store
            $fileNameToStore = $filename.'_'.time();
            //upload file
            $car->filename = $fileNameToStore.'.'.$extension;
            try{
                if($car->save() && $file->move('logo/', $fileNameToStore.'.'.$extension)){
                    return response()->json(array('msg' => 'success'), 200);
                }
            }catch (\Exception $e){
                return response()->json(['msg' => 'error', 'status' => $e]);
            }
            

        }
        else{

            if($car->save()){
                return response()->json(array('msg' => 'success'), 200);
            }

        }
        
        return response()->json(array('msg' => 'error'), 200);
    }

    public function delete(Car $car){

            try{
                unlink('logo/'.$car->filename);
                $car->delete();
                return response()->json(array('msg' => 'success', 'status' => 'no file'), 200);
            }catch (\Exception $e) {
                if($car->delete()){
                    return response()->json(array('msg' => 'success', 'status' => $e), 200);
                }
            }
        return response()->json(array('msg' => 'error'), 200);
    }

}

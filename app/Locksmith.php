<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Locksmith extends Model
{
    protected $guarded = [];

    public function card()
    {
    	return $this->hasOne('App\Card')->first();
    }

    public function credentials()
    {
    	return $this->hasOne('App\User')->first();
    }

    public function transactions()
    {
        return $this->hasMany('App\Transaction')->latest()->get();
    }

    public function process()
    {
        return $this->hasMany('App\Process')->get();
    }

    public function files()
    {
        return $this->hasMany('App\File', 'uploader')->get();
    }
    
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $guarded = [];

    public function locksmith()
    {
    	return $this->belongsTo('App\Locksmith')->first();
    }

    public function car()
    {
    	return $this->belongsTo('App\Car')->get();
    }

    public function card()
    {
    	return $this->belongsTo('App\Card')->get();
    }

    public function process()
    {
        return $this->hasOne('App\Process')->first();
    }

    public function files()
    {
        return $this->hasMany('App\File')->get();
    }

}

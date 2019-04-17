<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Process extends Model
{
    protected $guarded = [];

    public function locksmith()
    {
    	return $this->belongsTo('App\Locksmith')->first();
    }

    public function transaction()
    {
    	return $this->belongsTo('App\Transaction')->first();
    }

    public function user()
    {
    	return $this->belongsTo('App\User')->first();
    }

}

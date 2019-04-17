<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $guarded = [];

    public function locksmith()
    {
    	return $this->belongsTo('App\Locksmith', 'id', 'uploader')->first();
    }

    public function transaction()
    {
    	return $this->belongsTo('App\Transaction', 'id', 'transaction_id')->first();
    }
}

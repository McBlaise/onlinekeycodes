<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    protected $guarded = [];

    public function locksmith()
    {
    	return $this->belongsTo('App\Locksmith')->get();
    }

}

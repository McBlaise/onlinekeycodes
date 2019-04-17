<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    protected $guarded = [];

    public function transactions()
    {
        return $this->hasMany('App\Transaction')->get();
    }

}

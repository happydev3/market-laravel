<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StoreBankInfo extends Model
{

    protected $fillable = ['store_id','entrance_iban'];

    public function  store(){
        return $this->belongsTo('App\Models\Store');
    }
}

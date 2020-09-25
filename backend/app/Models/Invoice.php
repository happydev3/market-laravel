<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = ['date','type','transaction_id','store_id','import'];

    public function store(){
        return $this->belongsTo('App\Models\Store');
    }

}

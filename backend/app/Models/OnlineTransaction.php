<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OnlineTransaction extends Model
{
    protected $fillable = ['user_id','store_id','order_id','full_import','cashback','neto_import','invoice_id'];

    public function  user(){
        return $this->belongsTo('App\Models\User');
    }

    public function order(){
        return $this->belongsTo('App\Models\Order');
    }

    public function store(){
        return $this->belongsTo('App\Models\Store');
    }
}

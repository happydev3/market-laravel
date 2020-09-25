<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public function product(){
       return $this->belongsTo('App\Models\Product');
    }

    public function store(){
       return $this->belongsTo('App\Models\Store');
    }

    public function user(){
        return $this->belongsTo('App\Models\User');
    }

    public function online_transaction(){
        return $this->hasOne('App\Models\OnlineTransaction');
    }

    public function shipping_address(){
        return $this->hasOne('App\Models\OrderShippingAddress');
    }



}

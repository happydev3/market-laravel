<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StorePaymentConfig extends Model
{
    protected $fillable = ['store_id','connected','dp_connection_id','dp_connection_code','dp_pull_id','dp_pull_grant'];

    public function store(){
        return $this->belongsTo('App\Models\Store');
    }
}

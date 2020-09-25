<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserPaymentConfig extends Model
{
    protected $fillable = ['user_id','dp_connected','dp_connection_id','dp_connection_code'];

    public function user(){
        return $this->belongsTo('App\Models\User');
    }
}

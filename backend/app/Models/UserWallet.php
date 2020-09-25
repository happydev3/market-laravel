<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserWallet extends Model
{
    protected $fillable = ['user_id','account_balance','available_balance','friends_balance'];

    public function user(){
        return $this->belongsTo('App\Models\User');
    }
}

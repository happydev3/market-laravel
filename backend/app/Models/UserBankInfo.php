<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserBankInfo extends Model
{

    protected $fillable = ['user_id','exit_iban','income_iban'];


    public function user(){
        return $this->belongsTo('App\Models\User');
    }
}

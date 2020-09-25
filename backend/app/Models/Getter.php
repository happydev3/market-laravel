<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Getter extends Model
{
    protected $fillable = ['name','email','active','iban','referral_code','city_id','fb_fee'];

    public function city(){
       return $this->belongsTo('App\Models\City');
    }

    public function transactions(){
        return $this->hasMany('App\Models\GetterTransaction');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    protected $fillable = ['user_id','street_address','street_number','postal_code','name','additional_notes','city','country_id'];

    public function user(){
        return $this->belongsTo('App\Models\User');
    }
}

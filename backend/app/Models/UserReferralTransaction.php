<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserReferralTransaction extends Model
{

    protected $fillable = ['user_id','invited_user','dp_push_id','import','status'];
    protected $dates = ['created_at','updated_at'];

    public function user(){
        return $this->belongsTo('App\Models\User');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TradeDoublerTracking extends Model
{
    protected $fillable = ['subscription_id','user_id','program_id','site_id'];

    public function tdStore(){
        return $this->belongsTo('App\Models\TDStore','site_id');
    }

    public function user(){
        return $this->belongsTo('App\Models\User','user_id');
    }


}

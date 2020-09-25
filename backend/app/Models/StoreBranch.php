<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StoreBranch extends Model
{
    protected $fillable = ['store_id','street_address','lat','lng','active'];

    public function store(){
        return $this->belongsTo('App\Models\Store');
    }

    public function cashDesks(){
        return $this->hasMany('App\Models\CashDesk');
    }

    public function cashTransactions(){
        return $this->hasMany('App\Models\CashTransaction');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CashInvoice extends Model
{
    protected $fillable = ['invoice_number','date','store_id','total','freeback_fee','cashback_fee','valid'];

    public function cashTransactions(){
        return $this->hasMany('App\Models\CashTransaction');
    }

    public function store(){
        return $this->belongsTo('App\Models\Store');
    }
}

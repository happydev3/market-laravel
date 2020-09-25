<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CashTransaction extends Model
{
    protected $fillable = ['store_id','branch_id','cash_desk_id','user_id','full_import','discount_rate','freeback_rate','cashback_neto','freeback_neto','status','invoiced'];

    public function storeBranch(){
        return $this->belongsTo('App\Models\StoreBranch');
    }

    public function store(){
        return $this->belongsTo('App\Models\Store');
    }

    public function branch(){
        return $this->belongsTo('App\Models\StoreBranch');
    }

    public function user(){
        return $this->belongsTo('App\Models\User');
    }

    public function cashDesk(){
        return $this->belongsTo('App\Models\CashDesk');
    }

    public function invoice(){
        return $this->belongsTo('App\Models\CashInvoice');
    }
}

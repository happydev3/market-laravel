<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = ['store_id','user_id','full_import','cashback','neto_import','qr_code','invoice_id'];
    protected $dates = ['created_at','updated_at'];

    public function user(){
        return $this->belongsTo('App\Models\User');
    }

    public function store(){
        return $this->belongsTo('App\Models\Store');
    }


}

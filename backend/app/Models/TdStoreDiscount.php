<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TdStoreDiscount extends Model
{
    protected $fillable = ['category','cashback','active','t_d_store_id'];

    public function store(){
        return $this->belongsTo('App\Models\TDStore');
    }


}

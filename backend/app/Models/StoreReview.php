<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StoreReview extends Model
{
    protected $fillable = ['store_id','user_id','review','review'];

    public function store(){
        return $this->belongsTo('App\Models\Store');
    }

    public function user(){
        return $this->belongsTo('App\Models\User');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StoreVisits extends Model
{
    protected $fillable = ['user_id','store_id'];

    public function store(){
        return $this->belongsTo('App\Models\Store');
    }
}

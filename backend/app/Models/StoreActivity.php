<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StoreActivity extends Model
{
    protected $fillable = ['store_id','notification','type'];

    public function store(){
        return $this->belongsTo('App\Models\Store');
    }
}

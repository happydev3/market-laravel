<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StoreMultimedia extends Model
{
    public function store(){
        return $this->belongsTo('App\Models\Store');
    }
}

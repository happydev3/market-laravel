<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StoreNotification extends Model
{
    public function store(){
        return $this->belongsTo('App\Models\Store');
    }
}

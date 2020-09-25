<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StoreCategory extends Model
{
    protected $fillable = ['name','lang','active','slug'];

    public function stores(){
        return $this->hasMany('App\Models\Store');
    }

    public function externalStores(){
        return $this->hasMany('App\Models\TDStore');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StoreDocument extends Model
{
    protected $fillable = ['store_id','type','document_url','valid'];


    public function store(){
        return $this->belongsTo('App\Models\Store');
    }
}

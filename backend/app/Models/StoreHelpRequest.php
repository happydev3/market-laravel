<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StoreHelpRequest extends Model
{
    protected $fillable = ['store_id','request','answered','admin_id','answer'];

    public function store(){
        return $this->belongsTo('App\Models\Store');
    }

    public function admin(){
        return $this->belongsTo('App\Models\Admin');
    }


}

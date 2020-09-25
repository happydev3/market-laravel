<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TDTransaction extends Model
{

    protected $fillable = ['user_id','t_d_store','full_import','discount_rate','freeback_rate','cashback_neto','freeback_neto','active','royalty_check'];

    public function user(){
        return $this->belongsTo('App\Models\User');
    }

    public function store(){
        return $this->belongsTo('App\Models\TDStore','t_d_store');
    }


}

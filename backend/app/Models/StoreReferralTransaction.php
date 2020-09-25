<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StoreReferralTransaction extends Model
{
   protected $fillable = ['store_id','user_id','transaction_id','transaction_type','dp_push_id','status','import'];
   protected $dates = ['created_at','updated_at'];

    public function store()
    {
        return $this->belongsTo('App\Models\Store');
    }

}

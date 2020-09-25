<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GetterTransaction extends Model
{
    protected $fillable = ['getter_id','transaction_type','event','transaction_id','fb_fee_import','getter_fee_rate','import'];

    public function getter(){
        return $this->belongsTo('App\Models\Getter');
    }
}

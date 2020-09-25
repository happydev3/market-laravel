<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderShippingAddress extends Model
{
    protected $fillable = ['name','address','house_number','zip_code','city','country_id','additional_notes','invoice_details','order_id'];


    public function order(){
        return $this->belongsTo('App\Models\Order');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CashbackRequest extends Model
{
    protected $fillable = ['user_id','import','iban','status'];

    public function user(){
        return $this->belongsTo('App\Models\User');
    }
}

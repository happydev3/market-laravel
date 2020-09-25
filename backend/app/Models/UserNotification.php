<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserNotification extends Model
{
    protected $fillable = ['title','text','user_id','type'];

    public function user(){
        return $this->belongsTo('App\Models\User');
    }
}

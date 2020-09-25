<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserHelpRequest extends Model
{
    protected $fillable = ['user_id','request','answer','answered','admin_id'];

    public function user(){
        return $this->belongsTo('App\Models\User');
    }

    public function admin(){
        return $this->belongsTo('App\Models\Admin');
    }
}

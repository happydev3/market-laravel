<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PhoneVerifySms extends Model
{
    protected $fillable = ['phone_number','text','status'];

}

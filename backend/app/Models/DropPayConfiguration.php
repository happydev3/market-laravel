<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DropPayConfiguration extends Model
{
    protected $fillable = ['access_token','refresh_token','expires_in','valid'];
}

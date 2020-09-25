<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeesInfo extends Model
{
    protected $fillable = ['user_import','store_import','transaction_import','active','currency'];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dispute extends Model
{
    protected $fillable = ['transaction_id','user_id','store_id','order_id','problem_description'];
}

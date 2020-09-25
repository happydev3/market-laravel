<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CashDesk extends Model
{
    protected $fillable = ['store_branch_id','active','code','desk_name'];

    public function storeBranch(){
        return $this->belongsTo('App\Models\StoreBranch');
    }

    public  function cashTransactions(){
        return $this->hasMany('App\Models\CashTransaction');
    }

}

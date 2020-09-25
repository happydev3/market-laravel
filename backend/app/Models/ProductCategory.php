<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    protected $fillable =['name','active','lang','slug'];

    public function products(){
      return  $this->hasMany('App\Models\Product');
    }
}

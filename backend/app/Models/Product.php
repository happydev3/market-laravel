<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use function Sodium\add;

class Product extends Model
{

    const DEFAULT_IMAGE_THUMB  = "images/defaults/product_small.png";
    const DEFAULT_IMG_MAIN  ="images/defaults/product_big.png";

    protected $fillable = ['title','description','product_category_id','price','currency','store_id','store_internal_code','redirect_url','loaded_by','slug','quantity_available','active'];

    public function multimedia(){
        return $this->hasMany('App\Models\ProductMultimedia');
    }

    public function store(){
        return $this->belongsTo('App\Models\Store');
    }

    public function category(){
        return $this->belongsTo('App\Models\ProductCategory');
    }

    public function cart(){
        return $this->belongsToMany('App\Models\Cart','products_carts')->withPivot('quantity')->withTimestamps();
    }

    public function favourite(){
        return $this->belongsToMany('App\Models\UserFavourites','products_favourite');
    }

    public function order(){
        return $this->hasMany('App\Model\Order');
    }

    public function getWebThumb(){
        if($this->multimedia != null){
            $url = $this->multimedia->where('type','web_thumb')->first();
            if($url) {
                return $url->url;
            } else {
                return self::DEFAULT_IMAGE_THUMB;
            }
        } else return self::DEFAULT_IMAGE_THUMB;
    }

    public function sellable(){
        if(($this->active == 1) && ($this->quantity_available > 0)) {
            $store = $this->store;
           if(($store->paymentConfiguration->dp_connected == 1) && ($store->paymentConfiguration->dp_pull_granted == 1)){
                return true;
            }
        }
        else
            return false;
    }

}

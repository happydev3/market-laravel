<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TDStore extends Model
{
    const STORE_LOGO_DEFAULT_IMG_PATH = "images/defaults/store.jpg";
    const STORE_FRONT_IMG_DEFAULT_PATH = "images/defaults/store_small.png";
    const STORE_DEFAULT_BACKGROUND_PATH = "images/defaults/store_bg.jpg";


    protected $fillable = [
        'name',
        'website',
        'email',
        'target_url',
        'store_description',
        'front_thumbnail',
        'bg_image',
        'logo',
        'tracking_time',
        'credit_time',
        'cashback',
        'active',
        'slug',
        'store_category_id',
        'program_id',
    ];

    public function storeCategory(){
        return $this->belongsTo('App\Models\StoreCategory');
    }

    public function discounts(){
        return $this->hasMany('App\Models\TdStoreDiscount');
    }

    public function getEffectiveDiscount() {
        if($this->discounts()->count() > 0) {
            $discounts = $this->discounts()->get();
            $sum = 0;
            foreach($discounts as $d){
                $sum += $d->cashback;
            }
            $avgDiscount = $sum / count($discounts);

            return $avgDiscount - (($avgDiscount/100) * 30);
        } else {
            return 0;
        }
        
    }

    public function getBackgroundUrl(){
        $bgImg = $this->bg_image;
        if ((!$bgImg) || ($bgImg == "")) {
            return self::STORE_DEFAULT_BACKGROUND_PATH;
        } else {
            return $bgImg;
        }
    }

    public function getLogoUrl(){
        $logoUrl = $this->logo;
        if ((!$logoUrl) || ($logoUrl == "")) {
            return self::STORE_LOGO_DEFAULT_IMG_PATH;
        } else {
            return $logoUrl;
        }
    }

    public function getWebThumb(){
        $webThumb = $this->front_thumbnail;
        if ((!$webThumb) || ($webThumb == "")) {
            return self::STORE_FRONT_IMG_DEFAULT_PATH;
        } else {
            return $webThumb;
        }
    }

    public function trackings(){
        return $this->hasMany('App\Models\TradeDoublerTracking');
    }

}

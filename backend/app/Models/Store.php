<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\StoreResetPasswordNotification;


class Store extends Authenticatable
{
    use Notifiable;

    protected $fillable =['email','password','vat_number','business_name','street_address','lat','lng','phone_number','referral_code','phone_verify_code','email_verify_code','fb_fee','ae_code'];
    protected $hidden = ['password','rememberToken'];
    protected $guard = 'store';


    const STORE_LOGO_DEFAULT_IMG_PATH = "images/defaults/store.jpg";
    const STORE_FRONT_IMG_DEFAULT_PATH = "images/defaults/store_small.png";
    const STORE_DEFAULT_BACKGROUND_PATH = "images/defaults/store_bg.jpg";



    public function sendPasswordResetNotification($token)
    {
        $this->notify(new StoreResetPasswordNotification($token));
    }

    public function products(){
        return $this->hasMany('App\Models\Product');
    }

    public function branches(){
        return $this->hasMany('App\Models\StoreBranch');
    }

    public function multimedia(){
        return $this->hasOne('App\Models\StoreMultimedia');
    }

    public function visits(){
        return $this->hasMany('App\Models\StoreVisits');
    }

    public function store_category(){
        return $this->belongsTo('App\Models\StoreCategory');
    }

    public function recent_activity(){
        return $this->hasMany('App\Models\StoreActivity');
    }

    public function offline_transactions(){
        return $this->hasMany('App\Models\Transaction');
    }

    public function online_transactions(){
        return $this->hasMany('App\Models\OnlineTransaction');
    }

    public function cash_transactions(){
        return $this->hasMany('App\Models\CashTransaction');
    }

    public function paymentConfiguration(){
        return $this->hasOne('App\Models\StorePaymentConfig');
    }

    public function getAddress(){
        return $this->branches()->first();
    }

    public function isDropPayConnected(){
        if($this->paymentConfiguration != null){
            if($this->paymentConfiguration->dp_connected == 1){
                return true;
            }
            else{
                return false;
            }
        }
        return false;
    }

    public function isDropPayPullAuthorized(){
        if($this->paymentConfiguration != null){
            if($this->paymentConfiguration->dp_pull_granted == 1){
                return true;
            } else {
                return false;
            }
        }
        return false;
    }

    public function royaltyTransactions(){
        return $this->hasMany('App\Models\StoreReferralTransaction');
    }

    public function orders(){
        return $this->hasMany('App\Models\Order');
    }

    public function bank_info(){
        return $this->hasOne('App\Models\StoreBankInfo');
    }

    public function documents(){
        return $this->hasMany('App\Models\StoreDocument');
    }

    public function invoices(){
        return $this->hasMany('App\Models\Invoice');
    }

    public function cashInvoices(){
        return $this->hasMany('App\Models\CashInvoice');
    }

    public function storeIsActive(){
        return $this->active;
    }

    public function store_notifications(){
        return $this->hasMany('App\Models\StoreNotification');
    }

    public function reviews(){
        return $this->hasMany('App\Models\StoreReview');
    }

    public function effectiveCashback(){
        return  $this->discount_rate - (($this->freeback_rate/100) * $this->discount_rate);
    }

    public function getStoreLogo(){
        if($this->multimedia != null) {
            $logoUrl = $this->multimedia->logo_url;
            if (!$logoUrl) {
                return self::STORE_LOGO_DEFAULT_IMG_PATH;
            } else {
                return $logoUrl;
            }
        } else return self::STORE_LOGO_DEFAULT_IMG_PATH;
    }

    public function getStoreFrontImg(){
        if($this->multimedia != null){
            $frontUrl = $this->multimedia->front_image_thumbnail;
            if(!$frontUrl) {
                return self::STORE_FRONT_IMG_DEFAULT_PATH;
            } else {
                return $frontUrl;
            }
        } else return self::STORE_FRONT_IMG_DEFAULT_PATH;
    }

    public function getStoreBackgroundImg(){
        if($this->multimedia != null){
            $bgUrl = $this->multimedia->landing_background_url;
            if(!$bgUrl) {
                return self::STORE_DEFAULT_BACKGROUND_PATH;
            } else {
                return $bgUrl;
            }
        } else return self::STORE_DEFAULT_BACKGROUND_PATH;
    }

}

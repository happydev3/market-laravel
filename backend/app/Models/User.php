<?php

namespace App\Models;

use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;
    use CanResetPassword;

    protected $fillable = ['id','name', 'email', 'password','phone_no','avatar_url','email_verify_token','phone_verify_token','referral_code','api_token','own_referral_code','city_id','active_until','dp_connection_id','dp_connection_code'];
    protected $hidden = ['password', 'remember_token','api_token'];
    protected $dates = ['active_until'];


    const USER_DEFAULT_AVATAR = "images/defaults/user.jpg";

    public function bank_info(){
        return $this->hasOne('App\Models\UserBankInfo');
    }

    public function wallet(){
        return $this->hasOne('App\Models\UserWallet');
    }

    public function cashbackRequests(){
        return $this->hasMany('App\Models\CashbackRequest');
    }

    public function cashTransactions(){
        return $this->hasMany('App\Models\CashTransaction');
    }

    public function tdTransactions(){
        return $this->hasMany('App\Models\TDTransaction');
    }

    public function paymentConfiguration(){
        return $this->hasOne('App\Models\UserPaymentConfig');
    }

    public function address(){
        return $this->hasOne('App\Models\UserAddress');
    }

    public function city(){
        return $this->belongsTo('App\Models\City');
    }

    public function user_notifications(){
        return $this->hasMany('App\Models\UserNotification');
    }

    public function transactions(){
        return $this->hasMany('App\Models\Transaction');
    }

    public function online_transactons(){
        return $this->hasMany('App\Models\OnlineTransaction');
    }

    public function cash_transactions(){
        return $this->hasMany('App\Models\CashTransaction');
    }

    public function orders(){
        return $this->hasMany('App\Models\Order');
    }

    public function favourites(){
        return $this->belongsToMany('App\Models\Product','products_favourite')->withTimestamps();
    }

    public function reviews(){
        return $this->hasMany('App\Models\StoreReview');
    }


    public function isUserCompleted(){
        if(($this->email_verified) && ($this->phone_verified)){
            return true;
        } else
            return false;
    }

    public function royaltyTransactions(){
        return $this->hasMany('App\Models\UserReferralTransaction');
    }

    public function userAvatarLink(){
        $avatarUrl = $this->avatar_url;
        if($avatarUrl != null) {
            return $avatarUrl;
        }
        else {
            return self::USER_DEFAULT_AVATAR;
        }
    }

    public function tdTrackings(){
        return $this->hasMany('App\Models\TradeDoublerTracking');
    }

}

<?php

namespace App\Http\Controllers\Auth;

use App\Models\Getter;
use App\Models\Store;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReferralCodeController extends Controller
{
    public function checkReferralCode($referralCode){
        $referralCode = strtoupper($referralCode);
        if((strlen($referralCode) < 10) || (strlen($referralCode) > 25)){
            return "invalid";
        } else {
            if(preg_match("/[USP]-[0-9][0-9][0-9][0-9][0-9][0-9][0-9]/",$referralCode)) {
                $referralType = $referralCode[0];
                switch ($referralType) {
                    case "S":
                        {
                            if (Store::where('own_referral_code', $referralCode)->count() == 1) {
                                return "valid";
                            } else return "invalid";
                            break;
                        }
                    case "U":
                        {
                            if (User::where('own_referral_code', $referralCode)->count() == 1) {
                                return "valid";//true;
                            } else return "invalid";
                            break;
                        }
                    case "P":
                        {
                            if (Getter::where('referral_code', $referralCode)->count() == 1) {
                                return "valid";
                            } else return "invalid";
                            break;
                        }
                }
            } else {
                if(Getter::where('referral_code',$referralCode)->count() == 1){
                    return "valid";
                } else return "invalid";
            }

        }
    }
}

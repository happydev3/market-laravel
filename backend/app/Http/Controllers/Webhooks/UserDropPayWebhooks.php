<?php

namespace App\Http\Controllers\Webhooks;

use App\External\DropPayService;
use App\Models\UserPaymentConfig;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserDropPayWebhooks extends Controller
{
    public function userConnectionWebhook(Request $request){
        $connectionId = $request['id'];
        if($connectionId != null){
            $userPaymentConfig = UserPaymentConfig::where('dp_connection_id',$connectionId)->firstOrFail();
            $dropPay = new DropPayService();
            $status = $dropPay->checkConnectionGrant($connectionId);

            if($status == "WAITING"){
                return response("PROCESSED",200);
            } else {
                if($status == "GRANTED"){
                    $userPaymentConfig->dp_connection_code = $request['code'];
                    $userPaymentConfig->dp_connected = 1;
                    $userPaymentConfig->save();
                } else {
                    $userPaymentConfig->dp_connected = 0;
                    $userPaymentConfig->dp_connection_id = $dropPay->createConnectionCode();
                    $userPaymentConfig->dp_connection_code = null;
                    $userPaymentConfig->save();
                }
            }
        }
        return response("PROCESSED",200);
    }
}

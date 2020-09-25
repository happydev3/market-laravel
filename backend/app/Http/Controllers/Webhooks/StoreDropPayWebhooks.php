<?php

namespace App\Http\Controllers\Webhooks;

use App\Mail\StoreOrderNotify;
use App\Mail\UserOrderDoneMail;
use App\Models\OnlineTransaction;
use App\Models\Order;
use App\Models\Product;
use App\Models\StoreNotification;
use App\Models\StorePaymentConfig;
use App\Models\Transaction;
use App\Models\User;
use App\Models\UserNotification;
use App\Models\UserWallet;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\External\DropPayService;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;

class StoreDropPayWebhooks extends Controller
{
    public function storeConnectionWebhook(Request $request){
        $connectionId = $request['id'];
        if($connectionId != null){
            $storePaymentConfig = StorePaymentConfig::where('dp_connection_id',$connectionId)->first();
            if($storePaymentConfig != null){
                $dropPay = new DropPayService();
                $status = $dropPay->checkConnectionGrant($connectionId);
                if($status ==  "WAITING"){
                    return response("PROCESSED",200);
                } else {
                    if($status == "GRANTED"){
                        $storePaymentConfig->dp_connection_code = $request['code'];
                        $storePaymentConfig->dp_connected = 1;
                        $storePaymentConfig->save();
                    } else {
                        $storePaymentConfig->dp_connected = 0;
                        $storePaymentConfig->dp_connection_id = $dropPay->createConnectionCode();
                        $storePaymentConfig->dp_connection_code = null;
                        $storePaymentConfig->save();
                    }
                }
            }
        }
        return response("PROCESSED",200);
    }


    public function storePullWebhook(Request $request){
        $jsonReq = json_decode($request->getContent(),true);
        $pullId = $jsonReq["edata"]["id"];
        $storePaymentConfig = StorePaymentConfig::where('dp_pull_id',$pullId)->first();
        $dropPay = new DropPayService();
        $pullStatus = $dropPay->checkPullStatus($pullId);
        switch($pullStatus){
            case "READY": {
                break;
            }
            case "SCHEDULED": {
                $storePaymentConfig->dp_pull_granted = 1;
                $storePaymentConfig->save();
                break;
            }
            case "RUNNING": {
                $storePaymentConfig->dp_pull_granted = 1;
                $storePaymentConfig->save();
                break;
            }
            default: {
                $storePaymentConfig->dp_pull_id = $dropPay->createPullRequestForStore();
                $storePaymentConfig->dp_pull_granted = 0;
                $storePaymentConfig->save();
                break;
            }
        }
        return response("PROCESSED",200);
    }

    public function onlineStoreTransactionWebhook(Request $request){
        File::put("onlineReq.txt",$request);
        $jsonReq = json_decode($request->getContent(),true);
        $pullId = $jsonReq["edata"]["id"];
        $transaction = OnlineTransaction::where('dp_pull_id',$pullId)->firstOrFail();
        $storePaymentConfig = StorePaymentConfig::where('store_id',$transaction->store_id)->firstOrFail();
        $dropPay = new DropPayService();
        $pullStatus = $dropPay->checkPullStatusByStore($storePaymentConfig->dp_connection_code,$pullId);
        switch($pullStatus){
            case "READY": {
                break;
            }
            case "DONE": {
                $transaction->status = "completed";
                $transaction->save();

                $order = Order::where('id',$transaction->order_id)->first();
                $order->status = "recieved";
                $order->save();

                $user_wallet = UserWallet::where('user_id',$transaction->user_id)->first();
                $user_wallet->account_balance += $transaction->cashback_neto;
                $user_wallet->save();

                $notification = new UserNotification();
                $notification->title = "Ordine Registrato!";
                $notification->text = "Abbiamo Inoltrato il tuo Ordine. Hai Ottenuto ".number_format($transaction->cashback_neto,2)."€ di Cashback.";
                $notification->user_id = $transaction->user_id;
                $notification->type = "general_info";
                $notification->save();

                $store_notification = new StoreNotification();
                $store_notification->title = "Nuovo Ordine";
                $store_notification->text = "Hai Appena Ricevuto un Ordine. Dagli un Occhiata.";
                $store_notification->store_id = $transaction->store_id;
                $store_notification->type = "general_info";
                $store_notification->save();

                $product = Product::where('id',$transaction->order->product_id)->first();
                $product->quantity_available -= $transaction->order->product_quantity;
                $product->save();
                Mail::to($transaction->store->email)->send(new StoreOrderNotify($transaction->store->business_name,$transaction->order->product, $transaction->order->product_quantity));
                Mail::to($transaction->user->email)->send(new UserOrderDoneMail($transaction->user->name));
                $importToPullFromStore = ($transaction->discount_rate / 100) * $transaction->full_import;
                $dropPay->cashbackPullRequest($transaction->store_id,$importToPullFromStore);
                $dropPay->distributeCashback($transaction->user_id,$transaction->cashback_neto);

                //Check Royalties

                $user = User::where('id',$transaction->user_id)->first();
                if($user->referral_code != null){
                    $refCode = $user->referral_code;

                }


                break;
            }
            case "FAILED": {
                $transaction->status = "error";
                $transaction->save();
                break;
            }
            case "REFUSED ": {
                $transaction->status = "refused";
                $transaction->save();
                break;
            }
        }
        return "PROCESSED";
    }


    public function offlineStoreTransactionWebhook(Request $request){
        File::put("offlineReq.txt",$request);
        $jsonReq = json_decode($request->getContent(),true);
        $pullId = $jsonReq["edata"]["id"];
        $transaction = Transaction::where('dp_pull_id',$pullId)->firstOrFail();
        $storePaymentConfig = StorePaymentConfig::where('store_id',$transaction->store_id)->firstOrFail();
        $dropPay = new DropPayService();
        $pullStatus = $dropPay->checkPullStatusByStore($storePaymentConfig->dp_connection_code,$pullId);
        switch($pullStatus){
            case "READY": {
                break;
            }
            case "DONE": {
                $transaction->status = "completed";
                $transaction->save();

                $user_wallet = UserWallet::where('user_id',$transaction->user_id)->first();
                $user_wallet->account_balance += $transaction->cashback_neto;
                $user_wallet->save();

                $importToPullFromStore = ($transaction->discount_rate / 100) * $transaction->full_import;
                $dropPay->cashbackPullRequest($transaction->store_id,$importToPullFromStore);
                $dropPay->distributeCashback($transaction->user_id,$transaction->cashback_neto);

                break;
            }
            case "FAILED": {
                $transaction->status = "error";
                $transaction->save();
                break;
            }
            case "REFUSED ": {
                $transaction->status = "refused";
                $transaction->save();
                break;
            }
        }
        return "PROCESSED";
    }

    public function tdtest(Request $request){
        File::put("tdreq.txt",$request);
        return;
    }

}

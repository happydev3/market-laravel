<?php

namespace App\Http\Controllers\Webhooks;

use App\Models\TDStore;
use App\Models\TDTransaction;
use App\Models\User;
use App\Models\UserWallet;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TradeDoublerWebhook extends Controller
{
    public function transaction($id,Request $request){

        $user = User::where('id',$id)->firstOrFail();
        $import = $request['import'];
        $program_id = $request['program_id'];
        $advertiser = $request['advertiser_id'];
        $orderValue = $request['order_value'];
        $transactionId = $request['transaction_id'];

        $tdStore = TDStore::where('program_id',$program_id)->firstOrFail();
        $discounts = $tdStore->discounts()->where('active',1)->get();

        $bruttoCashback = $this->cashbackOnTotal($orderValue,$this->discountAvg($discounts));
        $freebackFee = $this->freebackFee($bruttoCashback);
        $netoCashback = $bruttoCashback - $freebackFee;


        $tdTransaction = TDTransaction::create([
            'user_id' => $user->id,
            't_d_store' => $tdStore->id,
            'full_import' => $orderValue,
            'discount_rate' => $this->discountAvg($discounts),
            'freeback_rate' => 30,
            'cashback_neto' => $netoCashback,
            'freeback_neto' => $freebackFee,
            'active' => 1,
        ]);

        $wallet = UserWallet::where('user_id',$user->id)->firstOrFail();
        $wallet->available_balance += $tdTransaction->cashback_neto;
        $wallet->account_balance += $tdTransaction->cashback_neto;
        $wallet->save();

        return "PROCESSED";
    }


    private function freebackFee($cashback){
        return (30/100) * $cashback;
    }

    private function cashbackOnTotal($total,$avg){
        return ($avg/100) * ($total);
    }


    private function discountAvg($discounts){
        $sum = 0;
        foreach($discounts as $d) {
            $sum += $d->cashback;
        }
        return $sum / count($discounts);
    }

}

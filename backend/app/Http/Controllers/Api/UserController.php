<?php

namespace App\Http\Controllers\Api;

use App\External\DropPayService;
use App\External\TradeDoublerService;
use App\Models\CashDesk;
use App\Models\CashTransaction;
use App\Models\MarketingBanner;
use App\Models\OnlineTransaction;
use App\Models\PhoneVerifySms;
use App\Models\Store;
use App\Models\StoreBranch;
use App\Models\TDStore;
use App\Models\TDTransaction;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\TradeDoublerTracking;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;


class UserController extends Controller
{

    public function verifyPhoneNumber(Request $request){
        $verificationCode = $request['verification_code'];
        $user = Auth::guard('api')->user();

        if($user->phone_verify_token == $verificationCode){
            $user->phone_verified = 1;
            $user->save();
            return response()->json(["verified"=>true],200);
        } else {
            return response()->json(["verified"=>false],200);
        }
    }

    public function sendVerificationSms(){
        $user = Auth::guard('api')->user();
        if($user->phone_verified == 0){
               PhoneVerifySms::create([
                   'text' => Lang::get('auth.sms_verify_text').$user->phone_verify_token,
                   'phone_number' => $user->phone_no,
               ]);
               return response()->json([],201);
        }
        else return response()->json([],400);
    }


    public function initOfflineTransaction(Request $request){
        $qr = explode(':',$request['qr_code']);
        $user = Auth::guard('api')->user();
        $store = Store::where('id',$qr[0])->firstOrFail();
        $fullImport = $qr[1];

        $dropPay = new DropPayService();
        $brutoCashback = $this->cashbackOnTotal($fullImport,$store);
        $freebackFee = $this->freebackFee($brutoCashback,$store);
        $netoCashback = $brutoCashback - $this->freebackFee($brutoCashback,$store);


        $transaction = new Transaction();
        $transaction->user_id = $user->id;
        $transaction->store_id = $store->id;
        $transaction->store_branch_id = $qr[4];
        $transaction->cash_desk_id = $qr[5];
        $transaction->full_import = $fullImport;
        $transaction->discount_rate = $store->discount_rate;
        $transaction->freeback_rate = $store->freeback_rate;
        $transaction->cashback_neto = $netoCashback;
        $transaction->freeback_neto = $freebackFee;
        $transaction->status = "created";
        $transaction->qr_code = $request['qr_code'];
        $transaction->notified = 0;
        $transaction->invoiced = 0;
        $transaction->dp_pull_id = $dropPay->createPullRequestByStoreOffline($store->paymentConfiguration->dp_connection_code, $transaction->full_import,$store->business_name);
        $transaction->save();

        return response()->json(['dp_pull_id'=>$transaction->dp_pull_id],200);
    }

    public function proposeCashTransaction(Request $request){
        $deskCode = $request['desk_code'];
        $fullImport = floatval($request['full_import']);
        $user = Auth::guard('api')->user();

        try {
            $desk = CashDesk::where('code',$deskCode)->firstOrFail();
            $storeBranch = StoreBranch::where('id',$desk->store_branch_id)->firstOrFail();
            $store = Store::where('id',$storeBranch->store_id)->firstOrFail();

            $brutoCashback = $this->cashbackOnTotal($fullImport,$store);
            $freebackFee = $this->freebackFee($brutoCashback,$store);
            $netoCashback = $brutoCashback - $this->freebackFee($brutoCashback,$store);

            $cashTransaction = new CashTransaction();
            $cashTransaction->store_id = $store->id;
            $cashTransaction->branch_id = $storeBranch->id;
            $cashTransaction->cash_desk_id = $desk->id;
            $cashTransaction->user_id = $user->id;
            $cashTransaction->full_import = $fullImport;
            $cashTransaction->discount_rate = $store->discount_rate;
            $cashTransaction->freeback_rate = $store->freeback_rate;
            $cashTransaction->freeback_neto = $freebackFee;
            $cashTransaction->cashback_neto = $netoCashback;
            $cashTransaction->status = "sent";
            $cashTransaction->save();
        } catch (\Exception $e){
            return response()->json(['status' => "error"],500);
        }
        return response()->json(['status' => 'created'],200);
    }


    public function userHomeData(){
        if(Auth::check()){
            $user = Auth::user();
            $marketing = MarketingBanner::where('active',1)->orderByRaw("RAND()")->limit(6)->get();
            return response()->json([
                'account_balance' => (float)$user->wallet->account_balance,
                'marketing' => $marketing,

            ],200,['Content-Type'=>'application/json'],JSON_PRESERVE_ZERO_FRACTION);
        } else {
            return response()->json(['error' => 'error'], 401);
        }
    }

    public function tdRedirect($id){
        $tdService = new TradeDoublerService();
        $user = Auth::user();
        $tdStore = TDStore::where('id',$id)->where('active',1)->firstOrFail();
        $subScriptionId = $tdService->createListener($user->name,$tdStore->program_id,3068510,$user->id);
        TradeDoublerTracking::create([
            'subscription_id' => $subScriptionId,
            'user_id' => $user->id,
            'program_id' => $tdStore->program_id,
            'site_id' => $tdStore->id,
        ]);

        return response(["redirect_url" => $tdStore->target_url],200);
    }


    public function userWallet(){
        $user = Auth::guard('api')->user();
        if($user){
            $tdTransactions = TDTransaction::where('user_id',$user->id)->where('active',1)->get();
            $online_transactions = OnlineTransaction::where('user_id',$user->id)->where('status','completed')->get();
            $transactions = Transaction::where('user_id',$user->id)->where('status','completed')->get();
            $cashTransactions = CashTransaction::where('user_id',$user->id)->where('status','accepted')->get();
            $merged = $online_transactions;

            foreach ($transactions as $t){
                $merged->push($t);
            }


            $tdTrans  = [];

            foreach($tdTransactions as $td) {
                array_push($tdTrans,[
                    'type' => "td",
                    'business_name' => $td->store->name,
                    'created_at' => Carbon::parse($td->created_at)->toDateTimeString(),
                    'date' => Carbon::parse($td->created_at)->format('d/m/20y'),
                    'order_id' => -1,
                    'id' => $td->id,
                    'full_import' => $td->full_import,
                    'discount_rate' => $td->discount_rate,
                    'freeback_rate' => $td->freeback_rate,
                    'cashback_neto' => $td->cashback_neto,
                ]);
            }

            foreach($tdTrans as $ct){
                $merged->push($ct);
            }

            foreach($cashTransactions as $ct){
                $merged->push($ct);
            }

            $all = array_reverse(array_sort($merged, function ($value) {
                return $value['created_at'];
            }));

            foreach($all as $a){
                if(isset($a["type"])) {
                } else {
                    $store = Store::where('id',$a->store_id)->first();
                    $a->business_name = $store->business_name;
                    $a->cashback = $store->effectiveCashback();
                    $a->date = $a->created_at->format('d/m/20y');
                    unset($a->created_at);
                    unset($a->store_id);
                }
            }

            return response()->json(['cashbackAmount' => $user->wallet->account_balance,'friendsAmount'=>$user->wallet->friends_balance,'transactions' => $all],200);
        }
        else {
            return response()->json(['error' => 'error'], 401);
        }
    }

    private function cashbackOnTotal($total,$store){
        $res =  ($store->discount_rate/100) * ($total);
        if($res == 0) {
            return 0.01;
        } else return $res;
    }

    private function freebackFee($cashback, $store){
        return ($store->freeback_rate/100) * $cashback;
    }

}

<?php

namespace App\Http\Controllers\User;

use App\Models\CashTransaction;
use App\Models\TDTransaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\OnlineTransaction;
use Illuminate\Support\Facades\Auth;


class WalletController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:web');
    }

    public function index(){
        $user = Auth::guard('web')->user();


        $data['todayAmount'] = $user->tdTransactions()->whereDate('created_at',Carbon::today())->where('active',1)->sum('cashback_neto') + $user->transactions()->whereDate('created_at',Carbon::today())->where('status','completed')->sum('cashback_neto') + $user->online_transactons()->whereDate('created_at',Carbon::today())->where('status','completed')->sum('cashback_neto') +
        $user->cash_transactions()->whereDate('created_at',Carbon::today())->where('status','accepted')->sum('cashback_neto');
        $data['availableAmount'] = $user->wallet->available_balance;
        $data['totalCashback'] = $user->wallet->account_balance;
        $data['friendsAmount'] = $user->wallet->friends_balance;

        $data['transactions'] = [];

        $online_transactions = OnlineTransaction::where('user_id',$user->id)->where('status','completed')->get();
        $transactions = Transaction::where('user_id',$user->id)->where('status','completed')->get();
        $cashTransactions = CashTransaction::where('user_id',$user->id)->where('status','accepted')->get();
        $tdTransactions = TDTransaction::where('user_id',$user->id)->where('active',1)->get();


        $merged = $transactions;
        foreach($online_transactions as $ot){
            $merged->push($ot);
        }

        foreach($cashTransactions as $ct){
            $merged->push($ct);
        }

        $tdTrans  = [];

        foreach($tdTransactions as $td) {
            array_push($tdTrans,[
                'type' => "td",
                'business_name' => $td->store->name,
                'created_at' => Carbon::parse($td->created_at)->toDateTimeString(),
                'order_id' => -1,
                'id' => $td->id,
                'full_import' => $td->full_import,
                'effective_cashback' => $td->store->getEffectiveDiscount(),
                'cashback_neto' => $td->cashback_neto,
            ]);
        }


        foreach($tdTrans as $ct){
            $merged->push($ct);
        }

        $all = array_reverse(array_sort($merged, function ($value) {
            return $value['created_at'];
        }));


        $data['transactions'] = $all;

        //return $all;


        return view('user.wallet',$data);
    }



    public function walletByDate(Request $request){

        $this->validate($request,[
            'date_from' => 'required',
            'date_to' => 'required',
        ]);

        $user = Auth::guard('web')->user();

        $dateFrom = Carbon::createFromFormat('d/m/Y',$request['date_from']);
        $dateTo= Carbon::createFromFormat('d/m/Y',$request['date_to']);
        $tdTransactions = $user->tdTransactions()->whereBetween('created_at',[$dateFrom->format('Y-m-d')." 00:00:00", $dateTo->format('Y-m-d')." 23:59:59"])->where('active',1)->get();
        $transactions = $user->transactions()->whereBetween('created_at', [$dateFrom->format('Y-m-d')." 00:00:00", $dateTo->format('Y-m-d')." 23:59:59"])->where('status','completed')->get();
        $onlineTransactions = $user->online_transactons()->whereBetween('created_at', [$dateFrom->format('Y-m-d')." 00:00:00", $dateTo->format('Y-m-d')." 23:59:59"])->where('status','completed')->get();
        $cashTransactions = $user->cash_transactions()->whereBetween('created_at', [$dateFrom->format('Y-m-d')." 00:00:00", $dateTo->format('Y-m-d')." 23:59:59"])->where('status','accepted')->get();


        $tdTrans  = [];

        foreach($tdTransactions as $td) {
            array_push($tdTrans,[
                'type' => "td",
                'business_name' => $td->store->name,
                'created_at' => Carbon::parse($td->created_at)->toDateTimeString(),
                'order_id' => -1,
                'id' => $td->id,
                'full_import' => $td->full_import,
                'effective_cashback' => $td->store->getEffectiveDiscount(),
                'cashback_neto' => $td->cashback_neto,
            ]);
        }





        $merged = $transactions;
        foreach($onlineTransactions as $ot){
            $merged->push($ot);
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

        $data['transactions'] = $all;
        $data['dateFrom'] = $dateFrom;
        $data['dateTo'] = $dateTo;

        return view('user.wallet_filter',$data);
    }
}

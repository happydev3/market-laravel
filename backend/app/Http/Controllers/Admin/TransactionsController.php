<?php

namespace App\Http\Controllers\Admin;

use App\Models\CashTransaction;
use App\Models\OnlineTransaction;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Carbon;

class TransactionsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index(){
        return view('admin.transactions');
    }

    public function getAllTransactions(){
        $onlineTransactions = OnlineTransaction::with(['user','store'])->get();
        $offlineTransactions = Transaction::with(['user','store'])->get();
        $cashTransactions = CashTransaction::with(['user','store'])->get();
        $merged = $offlineTransactions;

        foreach($onlineTransactions as $ot){
            $merged->push($ot);
        }

        foreach($cashTransactions as $ct){
            $merged->push($ct);
        }


       $all = array_reverse(array_sort($merged, function ($value) {
            return $value['created_at'];
        }));

        return $all;
    }

    public function todayOfflineTransactions(){
        $transactions = Transaction::whereDate('created_at',Carbon::today())->with(['user','store'])->get();
        return $transactions;
    }

    public function todayOnlineTransactions(){
        $transactions = OnlineTransaction::whereDate('created_at',Carbon::today())->with(['user','store'])->get();
        return $transactions;
    }

    public function onlineTransactions(){
        return view('admin.online_transactions')->with('onlineTransactionsCount',OnlineTransaction::count());
    }

    public function offlineTransactions(){
        return view('admin.offline_transactions')->with('offlineTransactionsCount',Transaction::count());
    }

    public function cashTransactions(){
        return view('admin.cash_transactions')->with('cashTransactionsCount',CashTransaction::count());
    }

    public function getCashTransactions(){
        $cashTransactions = CashTransaction::with(array('store'=>function($q){
            $q->select('id','business_name');
        }))->with(array('user'=>function($q){
            $q->select('id','name');
        }))->get();

        return $cashTransactions;
    }

    public function getOnlineTransactions(){
        $onlineTransactions = OnlineTransaction::with(array('store'=>function($q){
                $q->select('id','business_name');
        }))->with(array('user'=>function($q){
            $q->select('id','name');
        }))->get();

        return $onlineTransactions;
    }

    public function getOfflineTransactions(){
        $onlineTransactions = Transaction::with(array('store'=>function($q){
            $q->select('id','business_name');
        }))->with(array('user'=>function($q){
            $q->select('id','name');
        }))->get();

        return $onlineTransactions;
    }

}

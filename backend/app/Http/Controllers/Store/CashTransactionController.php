<?php

namespace App\Http\Controllers\Store;

use App\Models\CashTransaction;
use App\Models\StoreBranch;
use App\Models\User;
use App\Models\UserWallet;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CashTransactionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:store');
    }

    public function index(){

        $deskId = Session::get('desk_id');
        $branchId = Session::get('branch_id');
        $store = Auth::guard('store')->user();

        $branch = $store->branches()->where('id',$branchId)->where('active',1)->firstOrFail();
        $desk =  $branch->cashDesks()->where('id',$deskId)->where('active',1)->firstOrFail();
        $toConfirm = CashTransaction::where('branch_id',$branch->id)->where('cash_desk_id',$desk->id)->where('status','sent')->orderBy('created_at','DESC')->get();

        return view('store.cash_transactions')->with(['transactions' => $toConfirm]);
    }

    public function getTransactionNotification(){

        $deskId = Session::get('desk_id');
        $branchId = Session::get('branch_id');
        $store = Auth::guard('store')->user();

        $branch = $store->branches()->where('id',$branchId)->where('active',1)->firstOrFail();
        $desk =  $branch->cashDesks()->where('id',$deskId)->where('active',1)->firstOrFail();

        $toConfirm = CashTransaction::where('branch_id',$branch->id)->where('cash_desk_id',$desk->id)->where('status','sent')->where('notified',0)->get();

        foreach($toConfirm as $t){
            $t->notified = 1;
            $t->save();
        }
        return $toConfirm;
    }

    public function approveTransaction($id){
        $store = Auth::guard('store')->user();
        $cashTransaction = $store->cash_transactions()->where('id',$id)->where('status','sent')->firstOrFail();
        $user = User::where('id',$cashTransaction->user_id)->firstOrFail();

        $userWallet = UserWallet::where('user_id',$user->id)->firstOrFail();
        $userWallet->available_balance += $cashTransaction->cashback_neto;
        $userWallet->account_balance += $cashTransaction->cashback_neto;
        $userWallet->save();

        //Check for Royalties

        $cashTransaction->status = "accepted";
        $cashTransaction->save();

        return redirect()->back();
    }

    public function declineTransaction($id){
       $store = Auth::guard('store')->user();
       $transaction = $store->cash_transactions()->where('id',$id)->where('status','sent')->firstOrFail();
       $transaction->status = "declined";
       $transaction->save();
       return redirect()->back();
    }
}

<?php

namespace App\Http\Controllers\User;

use App\Models\City;
use App\Models\Country;
use App\Models\OnlineTransaction;
use App\Models\Order;
use App\Models\Transaction;
use App\Models\User;
use App\Models\UserNotification;
use App\Models\UserWallet;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class UserController extends Controller
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
        $data['totalCashback'] = $user->tdTransactions()->where('active',1)->sum('cashback_neto') + $user->transactions()->where('status','completed')->sum('cashback_neto') + $user->online_transactons()->where('status','completed')->sum('cashback_neto') +
            $user->cash_transactions()->where('status','accepted')->sum('cashback_neto');
        $data['friendsAmount'] = $user->wallet->friends_balance;

        $data['notifications'] = UserNotification::orderBy('created_at','DESC')->where('user_id',Auth::guard('web')->user()->id)->limit(6)->get();
        return view('user.index',$data);
    }

    public function orders(){
        $data['orders'] = Order::where('user_id',Auth::guard('web')->user()->id)->orderBy('created_at','DESC')->paginate(8);
        return view('user.shop_history',$data);
    }

}

<?php

namespace App\Http\Controllers\Store;

use App\External\DropPayService;
use App\Models\OnlineTransaction;
use App\Models\Product;
use App\Models\StoreActivity;
use App\Models\StoreNotification;
use App\Models\StoreVisits;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StoreController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:store');
    }

    public function index(){
        $store = Auth::guard('store')->user();

        $data['visitors'] = $store->visits()->whereDay('created_at',date('d'))->count();
        $data['products'] = $store->products->where('active',1)->count();
        $data['activities'] = $store->store_notifications()->whereDate('created_at','<=',DB::raw('CURDATE()'))->where('store_id',Auth::guard('store')->user()->id)->orderBy('created_at','DESC')->get()->take(8);

        $todayTotal =  $store->online_transactions()->whereDate('created_at','=',DB::raw('CURDATE()'))->where('status','completed')->sum('full_import') + $store->offline_transactions()->whereDate('created_at','=',DB::raw('CURDATE()'))->where('status','completed')->sum('full_import') +
                       $store->cash_transactions()->whereDate('created_at','=',DB::raw('CURDATE()'))->where('status','accepted')->sum('full_import');


        $todayCashback = $store->online_transactions()->whereDate('created_at','=',DB::raw('CURDATE()'))->where('status','completed')->sum('cashback_neto') +  $store->online_transactions()->whereDate('created_at','=',DB::raw('CURDATE()'))->where('status','completed')->sum('freeback_neto')
                        + $store->offline_transactions()->whereDate('created_at','=',DB::raw('CURDATE()'))->where('status','completed')->sum('cashback_neto') +  $store->offline_transactions()->whereDate('created_at','=',DB::raw('CURDATE()'))->where('status','completed')->sum('freeback_neto')
                        + $store->cash_transactions()->whereDate('created_at','=',DB::raw('CURDATE()'))->where('status','accepted')->sum('cashback_neto') +  $store->cash_transactions()->whereDate('created_at','=',DB::raw('CURDATE()'))->where('status','accepted')->sum('freeback_neto');


        $data['today_total'] =$todayTotal;
        $data['today_neto'] = $todayTotal - $todayCashback;

        return view('store.index',$data);
    }



    public function connectDropPay(){
        return view('auth.droppay_connect')->with('connection_id',Auth::guard('store')->user()->dp_connection_id);
    }

    public function authorizePull(){
        $dp = new DropPayService();
        $r = $dp->createPullRequestForStore();
        return $r->recipient->owner->name;
    }

    public function ajaxCheckConnection(){
        $store = Auth::guard('store')->user();
        if($store->dp_connected == 1){
            if($store->dp_connection_code != null){
                return "true";
            }
            else {
                return "false";
            }
        }
        return false;
    }

    public function offline_notification(){
        $unread = Transaction::where('store_id',Auth::guard('store')->user()->id)->where('notified',0)->where('status','completed')->get();
        foreach ($unread as $t){
            $t->notified = 1;
            $t->save();
        }
        return $unread;
    }
}

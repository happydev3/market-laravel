<?php

namespace App\Http\Controllers\Store;

use App\Models\CashTransaction;
use App\Models\OnlineTransaction;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StoreWalletController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:store');
    }

    public function index(){

        $store = Auth::guard('store')->user();

        $data['transactions_today'] = OnlineTransaction::where('store_id',$store->id)->whereDate('created_at','=',DB::raw('CURDATE()'))->where('status','completed')->count() +
                                      Transaction::where('store_id',$store->id)->whereDate('created_at','=',DB::raw('CURDATE()'))->where('status','completed')->count() +
                                      CashTransaction::where('store_id',$store->id)->whereDate('created_at','=',DB::raw('CURDATE()'))->where('status','accepted')->count();

        $data['transactions_month'] = OnlineTransaction::where('store_id',$store->id)->whereMonth('created_at','=',date('m'))->where('status','completed')->count() +
                                      Transaction::where('store_id',$store->id)->whereMonth('created_at','=',date('m'))->where('status','completed')->count() +
                                      CashTransaction::where('store_id',$store->id)->whereMonth('created_at','=',date('m'))->where('status','accepted')->count();


        $data['full_import'] = $store->offline_transactions->where('status','completed')->sum('full_import') + $store->online_transactions->where('status','completed')->sum('full_import') + $store->cash_transactions->where('status','accepted')->sum('full_import');

        $discountSum = Transaction::where('store_id',$store->id)->where('status','completed')->sum('cashback_neto') + Transaction::where('store_id',$store->id)->where('status','completed')->sum('freeback_neto')
                      + OnlineTransaction::where('store_id',$store->id)->where('status','completed')->sum('cashback_neto') + OnlineTransaction::where('store_id',$store->id)->where('status','completed')->sum('freeback_neto') +
                     CashTransaction::where('store_id',$store->id)->where('status','accepted')->sum('cashback_neto') + CashTransaction::where('store_id',$store->id)->where('status','accepted')->sum('freeback_neto');

        $data['neto_import'] = $data['full_import'] - $discountSum;
        $online_transactions = OnlineTransaction::where('store_id',$store->id)->where('status','completed')->get();
        $offline_transactions = Transaction::where('store_id',$store->id)->where('status','completed')->get();
        $cash_transactions = CashTransaction::where('store_id',$store->id)->where('status','accepted')->get();

        $merged = $online_transactions;


        foreach($offline_transactions as $ot){
            $merged->push($ot);
        }

        foreach($cash_transactions as $ct){
            $merged->push($ct);
        }

        $all = array_reverse(array_sort($merged, function ($value) {
            return $value['created_at'];
        }));

        $data['transactions'] = $all;

        return view('store.wallet',$data);
    }

    public function walletByDate(Request $request){
        $this->validate($request,[
            'date_from' => 'required',
            'date_to' => 'required',
        ]);

        $dateFrom = Carbon::createFromFormat('d/m/Y',$request['date_from']);
        $dateTo= Carbon::createFromFormat('d/m/Y',$request['date_to']);
        $transactions = Auth::guard('store')->user()->offline_transactions()->whereBetween('created_at', [$dateFrom->format('Y-m-d')." 00:00:00", $dateTo->format('Y-m-d')." 23:59:59"])->get();
        $onlineTransactions = Auth::guard('store')->user()->online_transactions()->whereBetween('created_at', [$dateFrom->format('Y-m-d')." 00:00:00", $dateTo->format('Y-m-d')." 23:59:59"])->get();
        $cashTransactions = Auth::guard('store')->user()->cash_transactions()->whereBetween('created_at',[$dateFrom->format('Y-m-d')." 00:00:00", $dateTo->format('Y-m-d')." 23:59:59"])->get();
        $merged = $transactions;
        foreach($onlineTransactions as $ot){
            $merged->push($ot);
        }

        foreach ($cashTransactions as $cashTransaction) {
            $merged->push($cashTransaction);
        }

        $all = array_reverse(array_sort($merged, function ($value) {
            return $value['created_at'];
        }));

        $data['transactions'] = $all;
        $data['dateFrom'] = $dateFrom;
        $data['dateTo'] = $dateTo;

        return view('store.wallet_filter',$data);


    }

}

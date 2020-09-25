<?php

namespace App\Http\Controllers\Admin;

use App\Models\CashTransaction;
use App\Models\Store;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CashSystemController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index(){
        $totalImport = CashTransaction::where('status','accepted')->where('invoiced',0)->sum('full_import');
        return view('admin.cash_system')->with('totalImport',$totalImport);
    }

    public function getStoreStatus(){
        $response = [];
        $stores = Store::select('id','business_name','email','discount_rate')->get();
        foreach ($stores as $store){
            $cashTransactions = CashTransaction::where('store_id',$store->id)->where('status','accepted')->where('invoiced',0)->count();
            if($cashTransactions > 0){
                array_push($response,[
                    'business_name' => $store->business_name,
                    'email' => $store->email,
                    'discount_rate' => $store->discount_rate,
                    'full_import' => CashTransaction::where('store_id',$store->id)->where('status','accepted')->where('invoiced',0)->sum('full_import'),
                    'cashback' => CashTransaction::where('store_id',$store->id)->where('status','accepted')->where('invoiced',0)->sum('cashback_neto'),
                    'freeback' => CashTransaction::where('store_id',$store->id)->where('status','accepted')->where('invoiced',0)->sum('freeback_neto'),
                ]);
            }
        }

        return $response;
    }


}

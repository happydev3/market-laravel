<?php

namespace App\Http\Controllers\Admin;

use App\Models\Getter;
use App\Models\GetterTransaction;
use App\Models\Store;
use App\Models\StoreReferralTransaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class RoyaltyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index(){
        $data['totalRoyaltiesGetter'] = Getter::where('active',1)->sum('fees_sum');
        $data['totalStoresRoyalties'] = StoreReferralTransaction::where('status','missing_payment')->sum('import');
        return view('admin.royalties',$data);
    }

    public function getGetterRoyalties(){
        $getters = Getter::where('fees_sum','>',0)->get();
        return $getters;
    }

    public function getStoreRoyalties(){
        $stores = Store::select('id','business_name','email')->get();
        $response = [];
        foreach($stores as $store){
            $transactionsImport = StoreReferralTransaction::where('status','missing_payment')->where('store_id',$store->id)->sum("import");
            if($transactionsImport > 0 ){
                array_push($response,[
                    'business_name' => $store->business_name,
                    'email' => $store->email,
                    'id' => $store->id,
                    'import' => $transactionsImport,
                ]);
            }
        }
        return $response;
    }

    public function markStoreRoyaltiesAsPaid($id){
        $store = Store::where('id',$id)->firstOrFail();
        $storeTransactions = StoreReferralTransaction::where('store_id',$store->id)->where('status','missing_payment')->get();
        foreach($storeTransactions as $transaction){
            $transaction->status = "completed";
            $transaction->save();
        }

        return redirect()->back();
    }

    public function markGetterRoyaltiesAsPaid($id){
        $getter = Getter::where('id',$id)->firstOrFail();
        $getterTransactions = GetterTransaction::where('getter_id',$getter->id)->where('status','missing_payment')->get();
        foreach($getterTransactions as $t){
            $t->status = "completed";
            $t->save();
        }
        $getter->fees_sum = 0;
        $getter->save();
        return redirect()->back();
    }


}

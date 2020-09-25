<?php

namespace App\Http\Controllers\Admin;

use App\Models\CashTransaction;
use App\Models\OnlineTransaction;
use App\Models\Product;
use App\Models\Store;
use App\Models\StoreBranch;
use App\Models\StoreDocument;
use App\Models\StoreReview;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Getter;
use App\Models\User;
use Illuminate\Support\Facades\Session;

class StoresController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index(){
        return view('admin.stores');
    }

    public function storeDetails($id){
        $store = Store::findOrFail($id);
        $data['store'] = $store;
        return view('admin.store_details',$data);
    }

    public function storeSwitchStatus(Request $request){

        $store = Store::where('id',$request['store_id'])->firstOrFail();
        if($store->active == 1){
            $store->active = 0;
            $store->save();
            Session::put('store_force_disable',1);
        } else {
            $store->email_verified = 1;
            $store->active = 1;
            $store->save();
            $storeDocuments = $store->documents;

            $missingDocuments = 3 - $storeDocuments->count();

            for($i = 0; $i<$missingDocuments; $i++){
                StoreDocument::create([
                    'store_id' => $store->id,
                    'type' => 'id',
                    'document_url' =>'#',
                    'valid'=>true,
                ]);
            }
            foreach($storeDocuments as $d){
                $d->valid = 1;
                $d->save();
            }
            Session::put('store_force_active',1);
        }

        return redirect()->back();

    }

    public function getStoreOnlineTransactions($id){
        $onlineTransactiosn = OnlineTransaction::select('id','full_import','user_id','cashback_neto','created_at')->with(array('user' => function($query){
            $query->select('id','name');
        }))->where('store_id',$id)->orderBy('created_at','DESC')->get();
        return $onlineTransactiosn;
    }

    public function getStoreOfflineTransactions($id){
        $offlineTransactions = Transaction::select('id','full_import','user_id','cashback_neto','created_at')->with(array('user' => function($query){
            $query->select('id','name');
        }))->where('store_id',$id)->get();
        return $offlineTransactions;
    }

    public function getStoreCashTransactions($id){
        $cashTransactions = CashTransaction::select('id','full_import','user_id','cashback_neto','created_at')->where('status','accepted')->with(array('user' => function($query){
            $query->select('id','name');
        }))->where('store_id',$id)->get();

        return $cashTransactions;
    }

    public function getStoreProducts($id){
        $products = Product::where('store_id',$id)->with(array('multimedia'=> function($query){
            $query->select('product_id','url')->where('type','web_thumb');
        }))->get();
        return $products;
    }

    public function getStoreReviews($id){
        $reviews = StoreReview::select('id','user_id','review','type','created_at')->with(array('user'=>function($query){
            $query->select('id','name');
        }))->where('store_id',$id)->get();

        return $reviews;
    }

    public function getStores(){
        $stores = Store::select('id','business_name','email','discount_rate','store_type','freeback_rate','created_at','referral_code')->get();
        
        foreach($stores as $store){
            if($store->referral_code != NULL){
                $referralType = $store->referral_code[0];
                $referralCode = $store->referral_code;
                switch ($referralType) {
                    case "S":
                        {   
                            $storeGetter = Store::where('own_referral_code', $referralCode)->first();
                            $store["invited_by"] = $storeGetter->business_name;
                            break;
                        }
                    case "U":
                        {
                            $generator = User::where('own_referral_code', $referralCode)->first();
                            $store["invited_by"] = $generator->name;
                            break;
                        }
                    default:
                        {
                            $getter = Getter::where('referral_code', $referralCode)->first();
                            if($getter){
                                $store["invited_by"] = $getter->name;
                            } else {
                                $store["invited_by"] = "NoBody";
                            } 
                            break;
                        }
                }
            }
            else {
                $store["referral_code"] = "NoRefferal";
                $store["invited_by"] = "NoBody"; 
            }
        }
        
        return $stores->toJson();
    }

    public function updateFreebackFee(Request $request){
        $this->validate($request,[
            'store_id' => 'required|numeric',
            'fb_fee' => 'required|numeric',
        ]);


        $store = Store::where('id',$request['store_id'])->firstOrFail();
        $store->freeback_rate = $request['fb_fee'];
        $store->save();

        Session::put('store_fee_updated',1);
        return redirect()->back();
    }

    public function getStoreBranches($id){
        $storeBranches = StoreBranch::where('store_id',$id)->withCount(["cashDesks" => function($q){
            $q->where('active',1);
        }])->get();
      /*  foreach($storeBranches as $sb){
            $desks = CashDesk::where('store_branch_id',$sb->id)->where('active',1)->count();
            $sb->push("desk_active",$desks);
            $sb->save();
        }*/
        return $storeBranches->toJson();
    }
}

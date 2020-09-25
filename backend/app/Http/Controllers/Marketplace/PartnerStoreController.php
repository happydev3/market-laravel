<?php

namespace App\Http\Controllers\Marketplace;

use App\External\TradeDoublerService;
use App\Models\Store;
use App\Models\StoreCategory;
use App\Models\TDStore;
use App\Http\Controllers\Controller;
use App\Models\TdStoreDiscount;
use App\Models\TradeDoublerTracking;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PartnerStoreController extends Controller
{
    public function index(){
      $data['storesCount'] =  TDStore::where('active',1)->count();
      $data['stores'] = TDStore::where('active',1)->paginate(10);
      return view('marketplace.partner_stores',$data);
    }


    public function redirectToTradeDoubler($id){
        $tdService = new TradeDoublerService();
        $user = Auth::guard('web')->user();
        $tdStore = TDStore::where('id',$id)->where('active',1)->firstOrFail();
        $subScriptionId = $tdService->createListener($user->name,$tdStore->program_id,3068510,$user->id);
        TradeDoublerTracking::create([
            'subscription_id' => $subScriptionId,
            'user_id' => $user->id,
            'program_id' => $tdStore->program_id,
            'site_id' => $tdStore->id,
        ]);
        return redirect($tdStore->target_url);
    }

    public function storesByCategory($slug){
        $storeCategory = StoreCategory::where('slug',$slug)->where('active',1)->firstOrFail();
        $data['stores'] = TDStore::where('active',1)->where('store_category_id',$storeCategory->id)->paginate(15);
        $data['category_name'] = $storeCategory->name;
        return view('marketplace.partner_stores_by_category',$data);
    }

    public function siglePartnerStore($slug){
        $data['store'] = TDStore::where('slug',$slug)->where('active',1)->firstOrFail();
        $discountRates = DB::table('td_store_discounts')->where('t_d_store_id',$data['store']->id)->where('active',1)->count();
        if($discountRates > 0) {
            $maxCashback = DB::table('td_store_discounts')->where('t_d_store_id',$data['store']->id)->where('active',1)->max("cashback");
        } else {
            $maxCashback = $data['store']->cashback;
        }
        $data['max_cashback'] = $maxCashback - ((30/100) *$maxCashback);
        $data['category'] = StoreCategory::where('id',$data['store']->store_category_id)->firstOrFail();
        return view('marketplace.partner_store',$data);
    }

}

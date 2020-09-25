<?php

namespace App\Http\Controllers\Marketplace;

use App\Models\OnlineTransaction;
use App\Models\Product;
use App\Models\StoreReview;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\StoreCategory;
use App\Http\Controllers\Controller;
use App\Models\Store;

class StoresController extends Controller
{
    public function index(Request $request){
        $data['store_categories'] = StoreCategory::where('active',1)->get();
        $data['stores'] = Store::where('active',1)->paginate(18);
        $data['stores_count'] = Store::where('active',1)->count();
        return view('marketplace.stores',$data);
    }

    public function storeLanding($permalink){
        $store = Store::where('permalink',$permalink)->where('active',1)->firstOrFail();
        $data['store_sales'] = $store->offline_transactions->count() + $store->online_transactions->count();
        $data['store'] = $store;
        $data['products'] = $data['store']->products()->paginate(9);
        return view('marketplace.store_landing',$data);
    }

    public function storesByType($type){
        $stores = null;
        switch($type){
            case "online":{
                $stores = Store::where('active',1)->where('store_type','online')->paginate(18);
                break;
            }

            case "physical": {
                $stores = Store::where('active',1)->where('store_type','physical')->paginate(18);
                break;
            }

            case "both": {
                $stores = Store::where('active',1)->where('store_type','both')->paginate(18);
                break;
            }
            default: {
                abort(404);
                break;
            }
        }

        $data['store_categiries'] = StoreCategory::where('active',1)->get();
        $data['stores_count'] = Store::where('store_type',$type)->count();
        $data['stores_type'] = $type;
        $data['stores'] = $stores;

        return view('marketplace.stores',$data);
    }

    public function storesByCategory($slug){
            $storeCategory = StoreCategory::where('slug',$slug)->where('active',1)->firstOrFail();
            $data['stores'] = Store::where('store_category_id',$storeCategory->id)->paginate(18);
            $data['category_name'] = $storeCategory->name;
            $data['store_categories'] = StoreCategory::where('active',1)->get();
            return view('marketplace.stores_category',$data);
    }

    public function storeReviews($permalink){

        $store = Store::where('permalink',$permalink)->firstOrFail();

        $data['store'] = $store;
        $data['reviews'] = StoreReview::where('store_id',$store->id)->where('active',1)->orderBy('created_at','DESC')->paginate(6);
        $data['store_sales'] = 0;
        if($data['store']->store_type == 'physical'){
            $data['store_sales'] = $data['store']->offline_transactions->count();
        } else {
            $data['store_sales'] = $data['store']->orders->count();
        }
        return view('marketplace.store_reviews',$data);
    }
}

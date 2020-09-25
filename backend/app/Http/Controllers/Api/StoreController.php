<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\CashDesk;
use App\Models\Store;
use App\Models\StoreBranch;
use App\Models\StoreCategory;
use App\Models\TDStore;
use Illuminate\Support\Facades\DB;


class StoreController extends Controller
{
    public function getStores(){
        $stores = DB::table('stores')
                ->where('stores.active',1)
                ->join('store_multimedia','stores.id','=','store_multimedia.store_id')
                ->join('store_categories','stores.store_category_id','=','store_categories.id')
                ->select('stores.id','stores.business_name','stores.permalink','stores.discount_rate','stores.store_type', 'stores.freeback_rate','store_multimedia.front_image_thumbnail as imageUrl','store_categories.name as category','stores.store_category_id')
                ->orderBy('stores.created_at','DESC')
                ->get();

        $tdStores = DB::table('t_d_stores')->where('t_d_stores.active',1)
                    ->join('store_categories','t_d_stores.store_category_id','=','store_categories.id')
                    ->select('t_d_stores.id','t_d_stores.name','t_d_stores.cashback','t_d_stores.front_thumbnail','t_d_stores.store_category_id','store_categories.name as categoryName')->get();
       
        $partners = [];
        foreach($tdStores as $tdStore){
            array_push($partners,[
                'id' => $tdStore->id,
                'business_name' => $tdStore->name,
                'discount_rate' => $tdStore->cashback,
                'freeback_rate' => 30,
                'imageUrl' => $tdStore->front_thumbnail,
                'store_category_id' => $tdStore->store_category_id,
                'store_category' => $tdStore->categoryName,
            ]);
        }
        
        $response = [ 
            'premium' => $stores,
            'partners' => $partners,
        ];
        
        return response()->json($response,200, ['Content-Type'=>'application/json'],JSON_PRESERVE_ZERO_FRACTION);
    }

    public function getStoreCategories(){
        $categories = StoreCategory::where('active',1)->orderBy('name','ASC')->get(['id','name']);
        return response()->json($categories,200,['Content-Type'=>'application/json']);
    }

    public function storesByCategory($id){
        $category = StoreCategory::where('id',$id)->first();
        if($category){
            $stores = DB::table('stores')
                ->where('stores.active',1)
                ->where('stores.store_category_id',$category->id)
                ->join('store_multimedia','stores.id','=','store_multimedia.store_id')
                ->join('store_categories','stores.store_category_id','=','store_categories.id')
                ->select('stores.id','stores.business_name','stores.permalink','stores.discount_rate','stores.freeback_rate','stores.store_type','store_multimedia.front_image_thumbnail as imageUrl','store_categories.name as category')
                ->orderBy('stores.created_at','DESC')
                ->get();

            $tdStores = DB::table('t_d_stores')->where('t_d_stores.active',1)
                    ->where('t_d_stores.store_category_id',$category->id)
                    ->join('store_categories','t_d_stores.store_category_id','=','store_categories.id')
                    ->select('t_d_stores.id','t_d_stores.name','t_d_stores.cashback','t_d_stores.front_thumbnail','t_d_stores.store_category_id','store_categories.name as categoryName')->get();


                    $partners = [];
                    foreach($tdStores as $tdStore){
                        array_push($partners,[
                            'id' => $tdStore->id,
                            'business_name' => $tdStore->name,
                            'discount_rate' => $tdStore->cashback,
                            'freeback_rate' => 30,
                            'imageUrl' => $tdStore->front_thumbnail,
                            'store_category_id' => $tdStore->store_category_id,
                            'store_category' => $tdStore->categoryName,
                        ]);
                    }
            
            $response = [
                'premium' => $stores,
                'partners' => $partners,
            ];
            return response()->json($response,200, ['Content-Type'=>'application/json'],JSON_PRESERVE_ZERO_FRACTION);
        } else {
            return response()->json(["message" => "Not Found"],404,['Content-Type'=>"application/json"]);
        }
    }

    public function checkStoreStatus($id){
        $store = Store::where('id',$id)->first();
        if($store) {
          return response()->json(['store_status'=>'active'],200);
        } else {
          return response()->json(['store_status'=>'unactive'],200);
        }
    }

    public function checkStoreDpStatus($id){
        $store = Store::where('id',$id)->firstOrFail();
        $dpConfig = $store->paymentConfiguration;
        if($store->active == 1){
           if(($dpConfig->dp_connected == 1) && ($dpConfig->dp_pull_granted)){
               return response()->json(['store_status'=>'active'],200);
           } else {
               return response()->json(['store_status'=>'unactive'],200);
           }
       } else {
           return response()->json(['store_status'=>'unactive'],200);
       }
    }

    public function checkCashDesk($code)
    {
        $cashDesk = CashDesk::where('code', $code)->firstOrFail();
        $branch = StoreBranch::where('id', $cashDesk->store_branch_id)->firstOrFail();
        $store = Store::where('id', $branch->store_id)->firstOrFail();

        if ($store->active == 1) {
            if ($branch->active == 1) {
                if ($cashDesk->active == 1)
                    return response()->json([
                        'status' => 'active'
                    ], 200);
            }
        }
        return response()->json(['status' => 'unactive'],400);
    }

    public function storeCheckoutDetails($code){
        $qrDecoded = explode(":",$code);
        $store = Store::where('id',$qrDecoded[0])->firstOrFail();
        $branch = $store->branches()->where('id',$qrDecoded[4])->firstOrFail();
        $cashDesk = $branch->cashDesks()->where('id',$qrDecoded[5])->firstOrFail();
        if($store and $store->active == 1){
            return response()->json([
               'business_name' => $store->business_name,
               'store_address' => $branch->street_address,
               'desk_name' => $cashDesk->desk_name,
               'store_img_url' => $store->multimedia->front_image_thumbnail,
            ],200,['Content-Type' => 'application/json']);
        } else {
            return response()->json(['error'=>'Store Not Found.'],404);
        }
    }

    public function storeCheckoutInCash($deskCode){
        $cashDesk = CashDesk::where('code',$deskCode)->first();
        if($cashDesk->active == 1) {
            $branch = StoreBranch::where('id',$cashDesk->store_branch_id)->first();
            if($branch->active == 1){
                $store = Store::where('id',$branch->store_id)->first();
                if($store->active == 1){
                    return response()->json([
                        'store_bg_url' => $store->multimedia->front_image_thumbnail,
                        'business_name' => $store->business_name,
                        'street_address' => $branch->street_address,
                        'desk_name' => $cashDesk->desk_name,
                        'discount_rate' => number_format((float)$store->effectiveCashback(), 2, '.', ''),
                    ],200);
                }
            }
        } else {
            return response()->json(['error'=>'Store Not Found.'],404);
        }
    }


    public function storeDetails($id)
    {
        $store = Store::where('id', $id)->with('multimedia')->first();
        $store = [
            'business_name' => $store->business_name,
            'img_url' => $store->multimedia->front_image_thumbnail,
            'cashback' => $store->effectiveCashback(),
            'category' => $store->store_category->name,
            'store_type' => $store->type,
            'store_branches' => $store->branches()->where('active',1)->get(['street_address','lat','lng']),
        ];
        return response()->json($store, 200, ['Content-Type' => 'application/json']);
    }

    public function tdStoreDetails($id){
        $tdStore = TDStore::where('id',$id)->first();
        $store = [
            'id' => $tdStore->id,
            'business_name' => $tdStore->name,
            'img_url' => $tdStore->front_thumbnail,
            'cashback' => $tdStore->getEffectiveDiscount(),
            'category' => $tdStore->storeCategory->name,
        ];
        return response()->json($store, 200, ['Content-Type' => 'application/json']);
    }

    public function get_nearest($lat,$long,$distance)
    {
        $circle_radius_miles = 3959;
        $haversine = "(6371 * acos(cos(radians($lat))
	                     * cos(radians(stores.lat))
	                     * cos(radians(stores.long)
	                     - radians($long))
	                     + sin(radians($lat))
	                     * sin(radians(stores.lat))))";
        $query = Store::select('id', 'business_name','logo_url','discount_rate')//pick the columns you want here.
        ->selectRaw("{$haversine} AS distance")
            ->whereRaw("$haversine < ?", [$distance])
            ->orderBy('distance')
            ->limit(20)
            ->get();
        return $query->toJson();
    }

    public function new_stores(){
        $stores = Store::select(['id','business_name','discount_rate'])->with('multimedia')->limit(25)->orderBy('created_at','DESC')->orderBy(DB::raw('RAND()'))->get();
        return $stores;
    }

    public function getStoresAround(){
        $stores = Store::select('business_name','discount_rate', 'freeback_rate','id')->where('store_type','both')->orWhere('store_type','physical')->with(['branches' => function($q){
            return $q->select('street_address','lat','lng','store_id')->where('active',1);
        }])->get();
        return $stores;
    }

}

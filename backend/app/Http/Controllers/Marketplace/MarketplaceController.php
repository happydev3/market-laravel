<?php

namespace App\Http\Controllers\Marketplace;


use App\Models\NewsletterSubscription;
use App\Models\Store;
use App\Models\TDStore;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\StoreCategory;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;


class MarketplaceController extends Controller
{
    public function index(){
      /*  $data['latest_products'] = Product::orderBy(DB::raw('RAND()'))->with('multimedia')->take(20)->get();
        $data['other1_products'] = Product::orderBy(DB::raw('RAND()'))->with('multimedia')->take(18)->get();
        $data['other2_products'] = Product::orderBy(DB::raw('RAND()'))->with('multimedia')->take(22)->get();
        $data['other3_products'] = Product::orderBy(DB::raw('RAND()'))->with('multimedia')->take(16)->get();
        $data['other4_products'] = Product::orderBy(DB::raw('RAND()'))->with('multimedia')->take(24)->get(); */
        $data['premiumStores'] = Store::where('active',1)->orderBy(DB::raw('RAND()'))->take(24)->get();
        $data['tradeDoubler'] = TDStore::where('active',1)->orderBy(DB::raw('RAND()'))->take(24)->get();
        $data['store_categories'] = StoreCategory::where('active',1)->orderBy('name','ASC')->get();
        return view('marketplace.index',$data);
    }


    public function acceptCookies(){
        Cookie::queue("fb_cookie_accept",1,2628000);
        return redirect()->back();
    }


    public function search($query,$category = 0){
        if(Input::get('category',0) == 0){
            $data['products'] = Product::where('title','LIKE','%'.Input::get('query',"").'%')
                                        ->orWhere('description','LIKE','%'.Input::get('query',"").'%')
                                        ->paginate(9);
            return view('marketplace.search_result',$data);
        }
        else
        {
            $data['products'] = Product::where('title','LIKE','%'.Input::get('query',"").'%')
                ->orWhere('description','LIKE','%'.Input::get('query',"").'%')
                ->where('product_category_id',Input::get('category',0))
                ->paginate(9);
                return view('marketplace.search_result',$data);
        }
    }

    public function subscribeToNewsLetter(Request $request)
    {
          $this->validate($request,[
               'subscribe_email' => 'email|required',
           ]);


           $user = User::where('email',$request['email'])->first();
           if(($user) && ($user->newsletter == 0)){
               $user->newsletter = 1;
               $user->save();
               return response()->json("ok",200);
           }

           $newsLetterUser = NewsletterSubscription::where('email',$request['email'])->first();
           if(!$newsLetterUser){
               NewsletterSubscription::create([
                   'email' => $request['subscribe_email'],
                   'active'=> 1,
               ]);
           } else {
               $newsLetterUser->active = 1;
               $newsLetterUser->save();
           }
           return response()->json("ok",200);
    }

    public function mobileApp(){
        return view('marketplace.mobile_app');
    }

}

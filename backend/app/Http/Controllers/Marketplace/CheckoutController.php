<?php

namespace App\Http\Controllers\Marketplace;

use App\Models\Country;
use App\Models\Product;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;


class CheckoutController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:web');
    }

    public function checkOut($slug){
        $product = Product::where('slug',$slug)->with('multimedia')->firstOrFail();
        if($product->sellable()){
            $data['user'] = Auth::guard('web')->user();
            $data['countries'] = Country::all();
            $data['product'] = $product;
            return view('marketplace.checkout',$data);
        }
        else return redirect()->back();
    }

}

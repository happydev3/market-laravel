<?php

namespace App\Http\Controllers\Store;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class DiscountRateController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:store');
    }

    public function index(){
        return view('store.discount_rate');
    }

    public function update_discount_rate(Request $request){
        $this->validate($request,[
            'discount_rate' => 'required|numeric|min:0.1|max:99',
        ]);

        $store = Auth::guard('store')->user();
        $store->discount_rate = $request['discount_rate'];
        $store->save();

        Session::put('discount_updated',1);
        return redirect()->back();
    }
}

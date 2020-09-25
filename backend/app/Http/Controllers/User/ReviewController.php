<?php

namespace App\Http\Controllers\User;

use App\Models\Order;
use App\Models\Store;
use App\Models\StoreReview;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function add_review(Request $request){

        $this->validate($request,[
            'order_id' => 'required|numeric',
            'review' => 'required|string',
            'type' => 'in:positive,negative',
        ]);


        $order = Order::where('id',$request['order_id'])->first();
        $store = Store::where('id',$order->store_id)->first();

        $review = new StoreReview();
        $review->store_id = $store->id;
        $review-> user_id  = Auth::guard('web')->user()->id;
        $review->review = $request['review'];
        $review->type = $request['type'] == "positive" ? "positive" : "negative";
        $review->save();

        $order->reviewed = 1;
        $order->save();

        return redirect()->back();
    }
}

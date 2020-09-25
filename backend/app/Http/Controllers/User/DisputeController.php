<?php

namespace App\Http\Controllers\User;

use App\Mail\OrderDispute;
use App\Models\Dispute;
use App\Models\Order;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class DisputeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function openDispute($orderId){
        $order = Auth::guard('web')->user()->orders()->where('id',$orderId)->firstOrFail();
        if(!$order->disputed){
            if(Carbon::now() <= $order->disputable_until){
                return view('user.open_dispute')->with('order',$order);
            } else {
                abort(404);
            }
        }
        abort(404);
    }

    public function submitDispute(Request $request){
        $this->validate($request,[
            'order_id' => 'required|numeric',
            'message' => 'required|string',
        ]);
        $user = Auth::guard('web')->user();
        $order = $user->orders()->where('id',$request['order_id'])->firstOrFail();
        $product = Product::where('id',$order->product_id)->firstOrFail();
        if($order->disputed) {return redirect()->route('user.orders');}

        $dispute = Dispute::create([
            'transaction_id' => $order->online_transaction_id,
            'user_id' => $user->id,
            'store_id' => $order->store_id,
            'order_id' => $order->id,
            'problem_description' => $request['message']
        ]);

        Mail::to($order->store->email)->send(new OrderDispute($dispute,$order, $order->store, $user,$product));

        $order->disputed = 1;
        $order->save();

        return redirect()->route('user.orders');
    }

}

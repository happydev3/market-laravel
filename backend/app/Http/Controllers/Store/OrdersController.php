<?php

namespace App\Http\Controllers\Store;

use App\Mail\UserOrderShipped;
use App\Models\Order;
use App\Models\OrderShippingAddress;
use App\Models\User;
use App\Models\UserAddress;
use App\Models\UserNotification;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class OrdersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:store');
    }

    public function index(){
        $store = Auth::guard('store')->user();
        $data['orders'] =$store->orders()->where('status','!=','missing_payment')->orderBy('created_at','DESC')->paginate(12);
        return view('store.orders',$data);
    }

    public function manage_order($order_id){
        $store = Auth::guard('store')->user();
        $data['order'] = $store->orders()->where('id',$order_id)->firstOrFail();
        $data['shipping_address'] = $data['order']->shipping_address;
        return view('store.manage_order',$data);

    }

    public function order_details($order_id){
        $store = Auth::guard('store')->user();
        $data['order'] = $store->orders()->where('id',$order_id)->firstOrFail();
        $data['shipping_address'] = $data['order']->shipping_address;
        return view('store.order_details',$data);
    }


    public function complete_order(Request $request){

        $order = Order::where('id',$request['order_id'])->firstOrFail();
        $order->status = 'sent';
        $order->tracking_no = $request['tracking_no'];
        $order->courier = $request['courier'];
        $order->save();

        $user = User::where('id',$order->user_id)->first();
        Mail::to($user->email)->send(new UserOrderShipped($user->name_surname,$order));

        $notification = new UserNotification();
        $notification->title = "Ordine Spedito!";
        $notification->text = "L'ordine ORD_".$order->id." è stato Spedito. Codice di Tracking: ".$order->tracking_no." (".$order->courier.")";
        $notification->user_id = $order->user_id;
        $notification->type = "product_shipped";
        $notification->save();

        return redirect()->route('store.orders');
    }


}

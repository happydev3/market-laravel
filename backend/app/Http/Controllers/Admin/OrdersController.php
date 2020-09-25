<?php

namespace App\Http\Controllers\Admin;

use App\Models\Dispute;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrdersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index(){
        return view('admin.orders')->with('ordersCount',Order::count());
    }

    public function getOrders(){
        $orders = Order::with(array('user'=>function($query){
            $query->select('id','name');
        }))->with(array('store'=>function($query2){
            $query2->select('id','business_name');
        }))->get();

        return $orders;
    }

    public function orderDetails($id){
        $data['order'] = Order::findOrFail($id);
        if($data['order']->disputed) {
            $data['dispute'] = Dispute::where('order_id',$data['order']->id)->firstOrFail();
        }
        return view('admin.order_details',$data);
    }

    public function getOrderProducts($id){
        $order = Order::findOrFail($id);
        return $order->product()->with(array('multimedia'=>function($query){
            $query->select('product_id','url')->where('type','web_thumb');
        }))->get();
    }

}

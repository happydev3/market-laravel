<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class OrdersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:web');
    }

    public function index(){
            $orders = Auth::guard('web')->user()->orders()->where('status','!=','missing_payment')->orderBy('created_at','DESC')->paginate(8);
            $ordersCount = Auth::guard('web')->user()->orders->where('status','!=','missing_payment')->count();
            //$data['orders'] = Auth::guard('web')->user()->orders()->orderBy('created_at','DESC')->paginate(8);
            return view('user.shop_history')->with(['orders' => $orders, 'ordersCount' => $ordersCount]);
    }
}

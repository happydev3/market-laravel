<?php

namespace App\Http\Controllers\Store;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class QrCodeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:store');
    }

    public function index(){
        return view('store.qr_code');
    }

    public function createQRcode(Request $request){

        $store = Auth::guard('store')->user();

        $this->validate($request,[
            'import' => 'required|numeric',
        ]);

        $qr_code =$store->id.":".number_format($request['import'],2).":";
        $discount_rate = $store->effectiveCashback();
        $cashback = number_format($discount_rate/100*$request['import'],2);
        $qr_code .= $cashback.":".$discount_rate.":".Session::get('branch_id').":".Session::get('desk_id');

        $response = array(
            'status' => 'success',
            'qr_code' => $qr_code,
        );

        return \Response::json($response);

    }



}

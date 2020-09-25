<?php

namespace App\Http\Controllers\Store;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DropPayController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:store');
    }

    public function index(){
        $data['store'] = Auth::guard('store')->user();
        $data['dropPayConfig'] = $data['store']->paymentConfiguration;
        return view('store.droppay',$data);
    }

    public function checkDropPayStatusAjax(){

        $response = [];
        $store = Auth::guard('store')->user();
        if($store->paymentConfiguration->dp_connected == 1)
            $response["connection"] = 1;
        else
            $response["connection"] = 0;

        if($store->paymentConfiguration->dp_pull_granted == 1)
            $response["pull"] = 1;
        else
            $response["pull"] = 0;

        return $response;
    }

}

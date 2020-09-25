<?php

namespace App\Http\Controllers\Admin;

use App\Models\TradeDoublerTracking;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TDTrackingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index(){
        return view('admin.td_tracking');
    }

    public function getTrackingData(){
        $trackingData = TradeDoublerTracking::with(['tdStore' => function($q) {
            $q->select('id','name');
        },'user' => function($q){
            $q->select('id','name');
        }])->get();
        return $trackingData;
    }
}

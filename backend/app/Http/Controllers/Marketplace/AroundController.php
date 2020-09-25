<?php

namespace App\Http\Controllers\Marketplace;

use App\Models\Store;
use App\Http\Controllers\Controller;


class AroundController extends Controller
{
    public function index(){
        return view('marketplace.around');
    }

    public function getStores(){
       $stores = Store::select('business_name','discount_rate','freeback_rate','id')->where('store_type','both')->orWhere('store_type','physical')->with(['branches' => function($q){
           return $q->select('street_address','lat','lng','store_id')->where('active',1);
       }])->get();


      return $stores;
    }

    public function storesAround(){
        $locations = Store::select('business_name','discount_rate','freeback_rate','id')->where('store_type','both')->orWhere('store_type','physical')->with(['branches' => function($q){
            $q->select('street_address','lat','lng','store_id')->where('active',1);
        }])->get();

        foreach($locations as $l) {
            $l->discount_rate = $l->effectiveCashback();
        }

        return $locations;
    }
}

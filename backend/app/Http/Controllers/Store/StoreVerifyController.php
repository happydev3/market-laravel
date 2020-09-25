<?php

namespace App\Http\Controllers\Store;

use App\Mail\StoreMailVerified;
use App\Models\Store;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class StoreVerifyController extends Controller
{
    public function store_email_verify($token){

        $store = Store::where('email_verify_code',$token)->first();
        if($store == null){
            Session::put('store_email_verify_error',1);
        } else {
            $store->email_verified = 1;
            $store->save();
            Session::put('store_email_verified',1);
            Mail::to($store->email)->send(new StoreMailVerified($store->business_name));
        }

        return redirect()->route('store.login');
    }
}

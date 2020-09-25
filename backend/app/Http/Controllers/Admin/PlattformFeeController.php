<?php

namespace App\Http\Controllers\Admin;

use App\Models\FeesInfo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class PlattformFeeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index(){
        return view('admin.plattform_fees')->with('fees',FeesInfo::first());
    }

    public function updateFees(Request $request){

        $this->validate($request,[
            'user_import' => 'required|numeric',
            'store_import' => 'required|numeric',
            'transaction_import' => 'required|numeric',
            'royalty_fee' => 'required|numeric',
            'minimum_requestable_import' => 'required|numeric',
        ]);

        $fees = FeesInfo::first();
        $fees->user_import = $request['user_import'];
        $fees->store_import = $request['store_import'];
        $fees->transaction_import = $request['transaction_import'];
        $fees->royalty_fee = $request['royalty_fee'];
        $fees->minimum_requestable_import = $request['minimum_requestable_import'];
        $fees->save();

        Session::put('updated',1);
        return redirect()->back();
    }
}

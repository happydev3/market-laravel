<?php

namespace App\Http\Controllers\Admin;

use App\Models\CashbackRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CashbackRequestController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index(){
        return view('admin.cashback_requests');
    }

    public function getRequests(){
        $cashBackRequests = CashbackRequest::with('user')->orderBy('created_at','DESC')->get();
        return $cashBackRequests;
    }

    public function requestDetails($id){
        $cashbackRequest = CashbackRequest::where('id',$id)->firstOrFail();
        return view('admin.cashback_request_details')->with('cashbackRequest',$cashbackRequest);
    }

    public function processTransaction($id){
        $cashbackRequest = CashbackRequest::where('id',$id)->firstOrFail();
        $cashbackRequest->status = "done";
        $cashbackRequest->save();

        return redirect()->route('admin.cashback_requests');
    }
}

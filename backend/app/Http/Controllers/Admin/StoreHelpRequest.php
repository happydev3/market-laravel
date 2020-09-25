<?php

namespace App\Http\Controllers\Admin;

use App\Mail\HelpRequestResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class StoreHelpRequest extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index(){
        $data['requests'] = \App\Models\StoreHelpRequest::orderBy('created_at','desc')->paginate(12);
        return view('admin.store_help_requests',$data);
    }

    public function manageRequest($id){
        $data['request'] = \App\Models\StoreHelpRequest::where('id',$id)->first();
        return view('admin.manage_store_request',$data);
    }

    public function answerToRequest(Request $request){
        $this->validate($request,[
                'answer' => 'required|string',
            ]);

        $helpRequest = \App\Models\StoreHelpRequest::where('id',$request['request_id'])->first();
        if($helpRequest){
            $helpRequest->answer = $request['answer'];
            $helpRequest->answered = 1;
            $helpRequest->admin_id = Auth::guard('admin')->user()->id;
            $helpRequest->save();
        }

        Mail::to($helpRequest->store->email)->send(new HelpRequestResponse($helpRequest->store->business_name,$helpRequest->request,$helpRequest->answer));

        return redirect()->route('admin.store_help');
    }

    public function openRequest($id){
        $request = \App\Models\StoreHelpRequest::findOrFail($id);
        if($request->answered == 1){
            return view('admin.store_request_details')->with('request',$request);
        } else
            return redirect()->back();
    }


}

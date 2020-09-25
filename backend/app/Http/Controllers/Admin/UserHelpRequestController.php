<?php

namespace App\Http\Controllers\Admin;

use App\Mail\HelpRequestResponse;
use App\Models\UserHelpRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class UserHelpRequestController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index(){
        $data['requests'] = UserHelpRequest::orderBy('created_at','desc')->paginate(12);
        return view('admin.user_help_requests',$data);
    }

    public function showAnswerForm($id){
        $userRequest = UserHelpRequest::findOrFail($id);
        return view('admin.manage_user_request')->with('request',$userRequest);
    }

    public function answerToRequest(Request $request){
        $this->validate($request,[
            'answer' => 'required|string',
            'request_id' => 'required',
        ]);

        $helpRequest = UserHelpRequest::findOrFail($request['request_id']);
        $helpRequest->answer = $request['answer'];
        $helpRequest->answered = 1;
        $helpRequest->admin_id = Auth::guard('admin')->user()->id;
        $helpRequest->save();

        Mail::to($helpRequest->user->email)->send(new HelpRequestResponse($helpRequest->user->name,$helpRequest->request,$helpRequest->answer));


        return redirect()->route('admin.help_users');

    }

    public function showRequest($id){
        $helpRequest = UserHelpRequest::findOrFail($id);
        return view('admin.user_request_details')->with('request',$helpRequest);
    }
}

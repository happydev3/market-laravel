<?php

namespace App\Http\Controllers\User;

use App\Models\UserHelpRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class HelpController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:web');
    }

    public function index(){
        return view('user.help_center');
    }

    public function sendRequest(Request $request){

        $this->validate($request,[
            'problem_type' => 'required|string',
            'problem_message' => 'required|string',
        ]);

        UserHelpRequest::create([
            'user_id' => Auth::guard('web')->user()->id,
            'request' => $request['problem_type']. "-".$request['problem_message'],
            'answered' => 0,
        ]);

        Session::put('helpRequest',1);
        return redirect()->back();
    }
}

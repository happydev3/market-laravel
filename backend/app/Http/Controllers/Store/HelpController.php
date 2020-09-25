<?php

namespace App\Http\Controllers\Store;

use App\Models\StoreHelpRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class HelpController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:store');
    }

    public function index(){
        return view('store.help');
    }

    public function helpRequest(Request $request){

        $this->validate($request,[
            'message' => 'string|required',
        ]);

        $helpRequest = StoreHelpRequest::create([
            'store_id' => Auth::guard('store')->user()->id,
            'answer' => '',
            'admin_id' => 1,
            'request' => $request['problem_type'] . " - ".$request['message'],
        ]);

        if($helpRequest){
            Session::put('helpRequest',1);

        }
        return redirect()->back();
    }
}

<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DropPayController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:web');
    }

    public function index(){
        $data['dropPayConfig'] = Auth::guard('web')->user()->paymentConfiguration;
        return view('user.droppay',$data);
    }

    public function checkDropPayStatus(){
        return ["connected" => Auth::guard('web')->user()->paymentConfiguration->dp_connected];
    }

}

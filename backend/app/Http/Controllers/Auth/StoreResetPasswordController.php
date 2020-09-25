<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Password;
use Auth;

class StoreResetPasswordController extends Controller
{

    use ResetsPasswords;
    protected $redirectTo = '/store';

    public function __construct()
    {
        $this->middleware('guest:store');
    }

    protected function guard(){
        return Auth::guard('admin');
    }

    protected function broker(){
        return Password::broker('stores');
    }

    public function showResetForm(Request $request, $token = null)
    {
        return view('auth.passwords.store_reset')->with(['token'=>$token,'email'=>$request->email]);
    }

}


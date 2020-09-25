<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Support\Facades\Session;

class StoreLoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest:store',['except' => ['logout']]);
    }

    public function showLoginForm(){
        return view('auth.store_login');
    }

    public function login(Request $request){

        $this->validate($request,[
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        if(Auth::guard('store')->attempt(['email'=>$request->email,'password'=>$request->password],$request->remember)){
            return redirect()->intended(route('store.home'));
        }
        else {
            return redirect()->back()->withInput($request->only('email'));
        }

    }

    public function logout()
    {
        Session::flush();
        Auth::guard('store')->logout();
        return redirect('/');
    }

}

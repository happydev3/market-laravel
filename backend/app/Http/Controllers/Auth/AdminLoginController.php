<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;

class AdminLoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest:admin',['except' => ['logout']]);
    }


    public function showLoginForm(){
        return view('auth.admin_login');
    }

    public function login(Request $request){

        $this->validate($request,[
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        if(Auth::guard('admin')->attempt(['email'=>$request->email,'password'=>$request->password],false)){
            if(Auth::guard('admin')->user()->active == 1){
                return redirect()->intended(route('admin.home'));
            } else {
                Auth::guard('admin')->logout();
                return redirect()->back()->withInput($request->only('email'));
            }
        }

        return redirect()->back()->withInput($request->only('email'));
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect('/');
    }



}

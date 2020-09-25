<?php

namespace App\Http\Controllers\User;

use App\Mail\UserMailVerified;
use App\Models\PhoneVerifySms;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class UserVerifyController extends Controller
{

    public function emailVerify($token){
        $user = User::where('email_verify_token',$token)->first();
        if($user == null) {
            Session::put('email_verify_error',1);
        } else
        {
            $user->email_verified = 1;
            $user->save();
            Session::put('email_verified',1);
        }
        Mail::to($user->email)->send(new UserMailVerified($user->name));
        return redirect()->route('login');
    }

    public function getPhoneVerify(){
        if(Auth::guard('web')->check()){
            if(Auth::user()->phone_verified == 0)
                return view('user.verify_phone');
        }
        return redirect()->route('home');
    }

    public function resendSms(){
        if(Auth::guard('web')->check()){
            if(Auth::user()->phone_verified == 0){
                PhoneVerifySms::create([
                    'text' => Lang::get('auth.sms_verify_text').Auth::guard('web')->user()->phone_verify_token,
                    'phone_number' => Auth::guard('web')->user()->phone_no,
                ]);
                Session::put('sms_sent',1);
            }
        }
        return redirect()->back();
    }



    public function phoneVerify(Request $request){
        $this->validate($request,[
            'verify_code' => 'required|numeric',
        ]);

        $user = Auth::guard('web')->user();

        if($user->phone_verify_token == $request['verify_code']){
            $user->phone_verified = 1;
            $user->save();
            Session::put('phone_verified',1);

        } else {
            Session::put('wrong_code',1);
        }

        return redirect()->back();
    }

}

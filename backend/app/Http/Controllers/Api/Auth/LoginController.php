<?php

namespace App\Http\Controllers\Api\Auth;

use App\Mail\WelcomeMail;
use App\Models\City;
use App\Models\PhoneVerifySms;
use App\Models\User;
use App\Models\UserPaymentConfig;
use App\Models\UserWallet;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use App\External\DropPayService;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Mail;

class LoginController extends Controller
{

    const USER_DEFAULT_AVATAR_PATH = "images/defaults/user.jpg";


    public function login(Request $request){
        $this->validate($request,[
            'email' => 'required',
            'password' => 'required'
        ]);
        if(Auth::attempt(['email' => $request->email, 'password'=>$request->password]))
        {
            $user = Auth::user();
            $dropPay = [];

            if(($user->paymentConfiguration != null)){
                $dropPay = [
                    'dp_connected' => $user->paymentConfiguration->dp_connected,
                    'dp_connection_id' => $user->paymentConfiguration->dp_connection_id,
                    'dp_connection_code' => $user->paymentConfiguration->dp_connection_code,
                ];
            }

            return response()->json([
                'id' => $user->id,
                'name'=> $user->name,
                'email'=> $user->email,
                'phone_no'=>$user->phone_no,
                'phone_verification_code' => $user->phone_verify_token,
                'own_referral_code'=> $user->own_referral_code,
                'api_token'=>$user->api_token,
                'phone_no_verified'=> $user->phone_verified,
                'avatar_url' => $user->userAvatarLink(),
                'droppay' => $dropPay,
            ]);
        }
        else{
            return response()->json(['message'=>'error'],401);
        }
    }


    public function register(Request $request){
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:6',
            'city_id' => 'required|numeric',
            'phone_no' => 'required|string|min:9',
            'referral_code' => 'nullable|string',
        ]);


        if(User::where('email',$request['email'])->count() > 0){
            return response()->json([
                'email_occupied' => 1,
            ],400);
        }

        if(User::where('phone_no',$request['phone_no'])->count() > 0){
            return response()->json([
                'phone_occupied' => 1,
            ],400);
        }

        if(isset($request['referral_code'])) {
            if(User::where('own_referral_code',$request['referral_code'])->count() == 0){
                return response()->json([
                    'referral_inexistent' => 1,
                ],400);
            }
        }



        $user =  User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => bcrypt($request['password']),
            'phone_no' => $request['phone_no'],
            'city_id' => $request['city_id'],
            'email_verified' => false,
            'phone_verified' => false,
            'email_verify_token' => str_random(128),
            'phone_verify_token' => rand(pow(10, 4-1), pow(10, 4)-1),
            'api_token' => $this->generateUserApiToken(),
            'own_referral_code' => 'U-'.$this->generateUserOwnReferralCode(),
            'avatar_url' => self::USER_DEFAULT_AVATAR_PATH,
            'referral_code' => Input::get('referral_code',null),
            'active_until' => Carbon::now()->addYear(1),
            'status' => 'missing_payment',
        ]);


        $user->save();

        $wallet = new UserWallet();
        $wallet->user_id = $user->id;
        $wallet->save();

        $dropPay = new DropPayService();


        $paymentConfig = new UserPaymentConfig();
        $paymentConfig->user_id = $user->id;
        $paymentConfig->dp_connection_id = $dropPay->createConnectionCode();
        $paymentConfig->save();

        Mail::to($user->email)->send(new WelcomeMail($user->name,$user->email_verify_token));

        PhoneVerifySms::create([
            'text' => Lang::get('auth.sms_verify_text').$user->phone_verify_token,
            'phone_number' => $user->phone_no,
        ]);

        if( ($user->paymentConfiguration != null)){
            $dropPay = [
                'dp_connected' => $user->paymentConfiguration->dp_connected,
                'dp_connection_id' => $user->paymentConfiguration->dp_connection_id,
                'dp_connection_code' => $user->paymentConfiguration->dp_connection_code,
            ];
        }

        return response()->json([
            'id' => $user->id,
            'name'=> $user->name,
            'email'=> $user->email,
            'phone_no'=>$user->phone_no,
            'phone_verification_code' => $user->phone_verify_token,
            'own_referral_code'=> $user->own_referral_code,
            'api_token'=>$user->api_token,
            'phone_no_verified'=> $user->phone_verified,
            'avatar_url' => $user->userAvatarLink(),
            'droppay' => $dropPay,
        ]);
    }


    public function getCities(){
        $cities = City::orderBy('city_name','ASC')->get();
        return $cities;
    }


    private function generateUserOwnReferralCode(){
        $code = mt_rand(10000000,99999999);
        while(User::where('own_referral_code',$code)->first()){
            $code = mt_rand(10000000,99999999);
        }
        return $code;
    }

    private function generateUserApiToken(){
        $token = str_random(150);
        while(User::where('api_token',$token)->first()){
            $token = str_random(150);
        }
        return $token;
    }


    public function logout(Request $request){
        Auth::logout();
        return response()->json(['exit'=>'ok'],200);
    }

}

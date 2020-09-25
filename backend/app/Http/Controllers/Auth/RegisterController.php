<?php

namespace App\Http\Controllers\Auth;

use App\Mail\WelcomeMail;
use App\Models\PhoneVerifySms;
use App\Models\User;
use App\Http\Controllers\Controller;

use App\Models\UserPaymentConfig;
use Carbon\Carbon;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Models\UserWallet;
use App\External\DropPayService;

class RegisterController extends Controller
{
    use RegistersUsers;

    const USER_DEFAULT_AVATAR_PATH = "images/defaults/user.jpg";

    protected $redirectTo = '/user/home';
   // private $dropPay;

    public function __construct()
    {
        $this->middleware('guest');
      //  $this->dropPay = new DropPayService();
    }


    public function registerWithRefferal($referralCode){
        return view('auth.register')->with(['referral' => $referralCode]);
    }


    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'city_id' => 'required|numeric',
            'phone_no' => 'required|string|min:9|unique:users',
            'referral_code' => 'nullable|string|min:10|max:25',
        ]);
    }



    protected function create(array $data)
    {
        $user =  User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'phone_no' => $data['phone_no'],
            'city_id' => $data['city_id'],
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

        $paymentConfig = new UserPaymentConfig();
        $paymentConfig->user_id = $user->id;
        $paymentConfig->dp_connection_id = $this->generateUserApiToken();
        $paymentConfig->dp_connected = 1;
        $paymentConfig->dp_connection_code = $this->generateUserApiToken();
        $paymentConfig->save();

        Mail::to($user->email)->send(new WelcomeMail($user->name,$user->email_verify_token));

        PhoneVerifySms::create([
            'text' => Lang::get('auth.sms_verify_text').$user->phone_verify_token,
            'phone_number' => $user->phone_no,
        ]);

        return $user;
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
}

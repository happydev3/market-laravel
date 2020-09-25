<?php

namespace App\Http\Controllers\Auth;

use App\External\DropPayService;
use App\Mail\StoreWelcomeMail;
use App\Models\CashDesk;
use App\Models\FeesInfo;
use App\Models\StoreBranch;
use App\Models\StoreMultimedia;
use App\Models\StorePaymentConfig;
use Illuminate\Http\Request;
use App\Models\Store;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Mail;



class StoreRegisterController extends Controller
{

    const STORE_LOGO_DEFAULT_IMG_PATH = "images/defaults/store.jpg";
    const STORE_FRONT_IMG_DEFAULT_PATH = "images/defaults/store_small.png";
    const STORE_DEFAULT_BACKGROUND_PATH = "images/defaults/store_bg.jpg";


    public function __construct()
    {
         $this->middleware('guest:store');
    }


    public function showRegisterForm(){
        return view('auth.store_register');
    }

    public function registerWithRefferal($referralCode){
        return view('auth.store_register')->with(['referral' => $referralCode]);
    }


    public function register(Request $request){
        $this->validate($request,[
            'email' => 'required|email|unique:stores',
            'password' => 'required|confirmed|min:6',
            'business_name' => 'required|string',
            'vat_number' => 'required|string|unique:stores',
            'formatted_address' => 'required|string',
            'phone_number' => 'required|string|unique:stores',
            'store_type' => 'required|in:physical,online,both',
            'store_category' => 'required|numeric',
            'referral_code' => 'nullable|string|min:10|max:25',
            'ae_code' => 'required|string|size:7',
        ]);


        $store =  new Store();
        $store->email = $request->email;
        $store->password = bcrypt($request->password);
        $store->business_name = $request->business_name;
        $store->vat_number = $request->vat_number;
        $store->ae_code = Input::get("ae_code",null);
        $store->email_verify_code = str_random(140);
        $store->phone_number = $request->phone_number;
        $store->active = 1;

        $store->website = Input::get('web_site',"");
        $store->store_category_id = Input::get('store_category',1);
        $store->store_type = $request->store_type;
        $store->referral_code = Input::get('referral_code',null);
        $store->own_referral_code = 'S-'.$this->generateStoreOwnReferralCode();
        $store->permalink = $this->generatePermalink($store->business_name,$store->street_address);
        $store->freeback_rate = FeesInfo::where('active',1)->first()->transaction_import;


        $store->save();


        if(Auth::guard('store')->attempt(['email'=> $request->email, 'password'=>$request->password],$request->remember)){
            $multimedia = new StoreMultimedia();
            $multimedia->store_id = $store->id;
            $multimedia->save();
            $multimedia->front_image_thumbnail = self::STORE_FRONT_IMG_DEFAULT_PATH;
            $multimedia->logo_url = self::STORE_LOGO_DEFAULT_IMG_PATH;
            $multimedia->landing_background_url = self::STORE_DEFAULT_BACKGROUND_PATH;
            $multimedia->save();

            $storeBranch = StoreBranch::create([
                'store_id' => $store->id,
                'street_address' => $request['formatted_address'],
                'lat' => Input::get('lat',0),
                'lng' => Input::get('lng',0),
            ]);

            CashDesk::create([
                'store_branch_id' => $storeBranch->id,
                'desk_name' => 'Cassa 1',
                'code' => 'C-'.$this->generateCashDeskCode(),
                'active' => 1,
            ]);

         //   $dpService = new DropPayService();

            $dropPayConfig = new StorePaymentConfig();
            $dropPayConfig->store_id = $store->id;
            $dropPayConfig->dp_connected = 1;
            $dropPayConfig->dp_connection_id ="FAKE_CODE";
            $dropPayConfig->dp_pull_id ="FAKE_CODE";
            $dropPayConfig->dp_pull_granted = 1;
            $dropPayConfig->save();



            Mail::to($store->email)->send(new StoreWelcomeMail($store->business_name,$store->email_verify_code));
            return redirect()->intended(route('store.home'));
        }
        else {
            $store->delete();
            return redirect()->back()->withInput($request);
        }
    }


    private function generatePermalink($store_name,$street_address){
        $permalink = str_replace(" ","_",$store_name);
        $permalink  .= "_".str_replace(" ","-",$street_address)."-Cashback-".str_random(10);
        return $permalink;
    }


    private function generateStoreOwnReferralCode(){
        $code = mt_rand(10000000,99999999);
        while(Store::where('own_referral_code',$code)->first()){
            $code = mt_rand(10000000,99999999);
        }
        return $code;
    }

    private function generateCashDeskCode(){
        $code = mt_rand(10000,99999);
        while(CashDesk::where('code',$code)->first()){
            $code = mt_rand(10000,99999);
        }
        return $code;
    }

}

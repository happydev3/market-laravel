<?php

namespace App\Http\Controllers\User;

use App\Models\City;
use App\Models\Country;
use App\Models\User;
use App\Models\UserAddress;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Intervention\Image\ImageManagerStatic as Image;

class UserProfileController extends Controller
{

     const USER_AVATAR_DIRECTORY = "uploads/users/";
     const DEFAULT_AVATAR_URL = "images/defaults/user.jpg";
     const IMG_WIDTH = 128;
     const IMG_HEIGHT = 128;


    public function __construct()
    {
        $this->middleware('auth:web');
    }


    public function index(){
        $data['countries'] = Country::orderBy('country_name','ASC')->get();
        $data['cities'] = City::where('country_id',Auth::user()->city->country_id)->orderBy('city_name','ASC')->get();
        if(Auth::user()->address !=  null) $data['user_address'] = Auth::user()->address;
        return view('user.account_settings',$data);
    }


    public function update_profile_info(Request $request){

        $this->validate($request,[
            'name' => 'required|string',
            'email' => 'required',
            'phone_no' => 'required',
            'city_id' => 'required',
        ]);

        $user = Auth::user();
        $user->name = $request['name'];

        if($user->email != $request['email']){
            if($this->check_mail_exists($request['email']))
                Session::put('mail_occupied',1);
            else{
                $user->email = $request['email'];
                $user->email_verified = 0;
                $user->email_verify_token = str_random(256);
                // TODO - Send Verification Email
            }
        }

        if($user->phone_no != $request['phone_no']){
            if($this->check_phone_exists($request['phone_no'])){
                Session::put('phone_no_occupied',1);
            }
            else{
                $user->phone_no = $request['phone_no'];
                $user->phone_verified = 0;
                $user->phone_verify_token = str_random(6);
                //TODO - Send Verification SMS
            }
        }

        $user->city_id = $request['city_id'];

        $user->newsletter = Input::get('newsletter',0);

        if(isset($request['profile_pic'])){
            $old_url = $user->avatar_url;
            $user->avatar_url = $this->resize_and_move_profile_pic($request->file('profile_pic'));
            if($old_url != self::DEFAULT_AVATAR_URL){
                File::delete($old_url);
            }
        }

        $user->save();
        return redirect()->back();

    }

    //Create or Update User Shipping Info
    public function cor_user_shipping_info(Request $request){

       if(Auth::user()->address != null){
           $adress = Auth::user()->address->first();
           $adress->name = $request['name'];
           $adress->street_address = $request['street_address'];
           $adress->street_number = $request['street_number'];
           $adress->city = $request['city'];
           $adress->country_id = $request['country_id'];
           $adress->postal_code = $request['zip'];
           $adress->additional_notes = Input::get('notes','');
           $adress->save();
        }
        else
        {
            UserAddress::create([
                'user_id' => Auth::user()->id,
                'name' => $request['name'],
                'street_address' => $request['street_address'],
                'street_number' => $request['street_number'],
                'city' => $request['city'],
                'country_id' => $request['country_id'],
                'postal_code' => $request['zip'],
                'additional_notes' => Input::get('notes',''),
            ]);
        }

        return redirect()->back();
    }

    public function user_address(){
        if(Auth::guard('web')->user()->address != null){
            return Auth::guard('web')->user()->address;
        }
    }

    private function check_mail_exists($email){
        $user_count = User::where('email',$email)->count();
        if($user_count > 0)
            return true;
        else
            return false;
    }

    private function check_phone_exists($phone_no){
        $user_count = User::where('phone_no',$phone_no)->count();
        if($user_count > 0)
            return true;
        else
            return false;
    }

    private function resize_and_move_profile_pic($file){
        $path = $file->move(self::USER_AVATAR_DIRECTORY,'profile_'.str_random(22).".".$file->getClientOriginalExtension());
        $path = str_replace('\\','/',$path);
        Image::make($path)->fit(self::IMG_WIDTH,self::IMG_HEIGHT,function ($constraint){
            $constraint->aspectRatio();
        })->resizeCanvas(self::IMG_WIDTH,self::IMG_WIDTH,"center")->save($path)->blur(100);

        return $path;
    }
}

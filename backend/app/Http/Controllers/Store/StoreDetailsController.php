<?php

namespace App\Http\Controllers\Store;

use App\Models\Store;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;
use App\Models\StoreBankInfo;

class StoreDetailsController extends Controller
{

    const STORE_LOGO_WIDTH = 80;
    const STORE_LOGO_HEIGHT = 80;

    const STORE_MULTIMEDIA_PATH = 'uploads/stores/';

    const STORE_LOGO_FRONT_IMG_HEIGHT = 150;
    const STORE_LOGO_FRONT_IMG_WIDTH = 258;

    const STORE_LANDING_IMG_HEIGHT = 300;
    const STORE_LANDING_IMG_WIDTH  = 1500;

    const DEFAULT_LOGO_URL = "images/defaults/store.jpg";
    const DEFAULT_LANDING_URL = "images/defaults/store_bg.jpg";
    const DEFAULT_FRONT_THUMB_URL = "images/defaults/store_small.png";


    public function __construct()
    {
        $this->middleware('auth:store');
    }



    public function store_information(){
        return view('store.store_info');
    }


    public function store_information_update(Request $request){

        $this->validate($request,[
            'business_name' => 'string|required',
            'email' => 'email|required',
            'phone_number' => 'required|string',
            'website' => 'nullable|string',
            'store_type' => 'required|in:physical,online,both',
            'ae_code' => 'nullable:string',
            'store_category' => 'required:numeric',
        ]);


        $store = Auth::guard('store')->user();
        $store_multimedia  =  $store->multimedia;


        if($store->business_name != $request['business_name']){
            $store->business_name  = $request['business_name'];
            $store->permalink = str_replace(" ","_",$store->business_name)."_".str_random(20);
        }


        if($store->email != $request['email']){
            if($this->check_if_email_exists($request['email']))
                Session::put('mail_occupied',1);
            else {
                $store->email = $request['email'];
                $store->email_verified = 0;
                $store->email_verify_code = str_random(139);
            }
        }

        if($store->phone_number != $request['phone_number']){
            if($this->check_if_phone_exists($request['phone_number']))
                Session::put('phone_occupied',1);
            else
            {
                $store->phone_number = $request['phone_number'];
                $store->phone_no_verified = 0;
                $store->phone_verify_code = str_random(4);
            }
        }

        if(isset($request['store_profile_img'])){
            $old_logo_url = $store_multimedia->logo_url;
            $store_multimedia->logo_url = $this->store_profile_img($request->file('store_profile_img'));
            $store_multimedia->save();

            if($old_logo_url != self::DEFAULT_LOGO_URL){
                File::delete($old_logo_url);
            }
        }

        if(isset($request['store_thumb'])){
            $old_thumb_url = $store_multimedia->front_image_thumbnail;
            $store_multimedia->front_image_thumbnail = $this->front_img_thumb($request->file('store_thumb'));
            $store_multimedia->save();
            if($old_thumb_url != self::DEFAULT_FRONT_THUMB_URL){
                File::delete($old_thumb_url);
            }

        }

        if(isset($request['store_bg'])){
            $old_bg_url = $store_multimedia->landing_background_url;
            $store_multimedia->landing_background_url = $this->store_landing_bg($request->file("store_bg"));
            $store_multimedia->save();

            if($old_bg_url != self::DEFAULT_LANDING_URL){
                File::delete($old_bg_url);
            }
        }



        $store->store_type = $request['store_type'];
        $store->store_category_id = $request['store_category'];
        $store->ae_code = Input::get('ae_code',null);

        if(Input::get('website','') != '') {
            $http = strpos(Input::get('website',''),"http");
            if($http === false) {
                $store->website = "http://".Input::get('website');
            }
            else {
                $store->website = Input::get('website');
            }
        }
        $store->save();
        return redirect()->back();

    }


    private function check_if_email_exists($email){
         if(Store::where('email',$email)->count() > 0)
             return  true;
         else
             return false;
    }

    private function check_if_phone_exists($phone_no){
        if(Store::where('phone_number',$phone_no)->count() > 0)
            return true;
        else
            return false;
    }

    private function check_vat_no($vat_no){
        if(Store::where('vat_number',$vat_no)->count() > 0)
            return true;
        else
            return false;
    }

    private function store_profile_img($profile_img){
        $path = $profile_img->move(self::STORE_MULTIMEDIA_PATH,'store_front_'.str_random(22).".".$profile_img->getClientOriginalExtension());
        $path = str_replace('\\','/',$path);
        Image::make($path)->resize(self::STORE_LOGO_WIDTH,self::STORE_LOGO_HEIGHT,function($constraint){
            $constraint->aspectRatio();
        })->resizeCanvas(self::STORE_LOGO_WIDTH,self::STORE_LOGO_HEIGHT,'center',false,array(0,0,0,0))->save($path);;
        return $path;
    }

    private function store_landing_bg($landing_img){
        $path = $landing_img->move(self::STORE_MULTIMEDIA_PATH,'store_landing_'.str_random(22).".".$landing_img->getClientOriginalExtension());
        $path = str_replace('\\','/',$path);
        Image::make($path)->fit(self::STORE_LANDING_IMG_WIDTH,self::STORE_LANDING_IMG_HEIGHT,function($constraint){
            $constraint->aspectRatio();
        })->resizeCanvas(self::STORE_LANDING_IMG_WIDTH,self::STORE_LANDING_IMG_HEIGHT,'center',false,"#ffffff")->save($path);;
        return $path;
    }

    private function front_img_thumb($thumb){
        $path = $thumb->move(self::STORE_MULTIMEDIA_PATH,'store_thumb_'.str_random(22).".".$thumb->getClientOriginalExtension());
        $path = str_replace('\\','/',$path);
        Image::make($path)->resize(self::STORE_LOGO_FRONT_IMG_WIDTH,self::STORE_LOGO_FRONT_IMG_HEIGHT,function($constraint){
            $constraint->aspectRatio();
        })->resizeCanvas(self::STORE_LOGO_FRONT_IMG_WIDTH,self::STORE_LOGO_FRONT_IMG_HEIGHT,'center',false,"#ffffff")->save($path);;
        return $path;
    }


    public function store_address_update(Request $request){
        $this->validate($request,[
            'formatted_address' => 'required|string',
            'lat' => 'required|numeric',
            'lng' => 'required|numeric',
        ]);

        $store = Auth::guard('store')->user();
        $store->street_address = $request['formatted_address'];
        $store->lat = $request['lat'];
        $store->lng = $request['lng'];
        $store->save();

        return redirect()->back();
    }


}

<?php

namespace App\Http\Controllers\Admin;

use App\Models\City;
use App\Models\Getter;
use App\Models\Store;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class GetterController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index(){
        return view('admin.getters')->with('cities',City::orderBy('city_name','ASC')->get());
    }

    public function getGetters(){
        $getters = Getter::select('id','name','referral_code','email','city_id','created_at','active')->with(array('city' => function($query){
            $query->select('city_name','id');
        }))->get();
        return $getters;
    }

    public function swtichStatus($id){
        $getter = Getter::where('id',$id)->firstOrFail();
        if($getter->active == 1) {
            $getter->active = 0;
        } else {
            $getter->active = 1;
        }

        $getter->save();
        return redirect()->back();
    }

    public function createGetter(Request $request){

        $this->validate($request,[
            'name' => 'required|string',
            'email' => 'required|email|unique:getters',
            'iban' => 'required|string|unique:getters',
            'fee_rate' => 'required|numeric',
            'city_id' => 'required|numeric',
            'referral_code' => 'string',
        ]);

       $getter = new Getter();
       $getter->name = $request['name'];
       $getter->email = $request['email'];
       $getter->iban = str_replace(" ","",$request['iban']);
       $getter->fee_rate = $request['fee_rate'];
       $getter->city_id = $request['city_id'];

       if(isset($request['referral_code'])) {
           if(Getter::where('referral_code',$request['referral_code'])->count() > 0){
               Session::put('getter_code_occupied',1);
           } else {
               $getter->referral_code = $request['referral_code'];
           }
       } else {
           $getter->referral_code = "P-".$this->generateRefferalCode();
       }

       $getter->active = 1;
       $getter->save();

        return redirect()->back();
    }

     public function updateGetter(Request $request){
        $this->validate($request,[
            'getter_id' => 'required|numeric',
            'name' => 'required|string',
            'email' => 'required|email|',
            'iban' => 'required|string',
            'fb_fee' => 'required|numeric',
            'city_id' => 'required|numeric',
        ]);

        $getter = Getter::where('id',$request['getter_id'])->firstOrFail();

        if($request['email'] != $getter->email){
            $getterMail = Getter::where('email',$request['email'])->first();
            if(!$getterMail) {
                $getter->email = $request['email'];
            } else {
                Session::put('getter_mail_occupied',1);
                return redirect()->back();
            }
        }

         if($request['iban'] != $getter->iban){
             $getterIban = Getter::where('iban',$request['iban'])->first();
             if(!$getterIban) {
                 $getter->iban = $request['iban'];
             } else {
                 Session::put('getter_iban_occupied',1);
                 return redirect()->back();
             }
         }

        $getter->name = $request['name'];
        $getter->fee_rate = $request['fb_fee'];
        $getter->city_id = $request['city_id'];

        $getter->save();
        Session::put('getter_updated',1);
        return redirect()->back();
    }

    public function getGetter($id){
        $data['getter'] = Getter::findOrFail($id);
        $data['invitedStores'] = Store::where('referral_code',$data['getter']->referral_code)->count();
        $data['invitedUsers'] = User::where('referral_code',$data['getter']->referral_code)->count();
        $data['cities'] = City::orderBy('city_name','ASC')->get();
        return view('admin.getter_details',$data);
    }

    public function getGetterTransactions($id){
        $getter = Getter::where('id',$id)->firstOrFail();
        return $getter->transactions;
    }

    private function generateRefferalCode(){
        $code = mt_rand(10000000,99999999);
        while(Getter::where('referral_code',$code)->first()){
            $code = mt_rand(10000000,99999999);
        }
        return $code;
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Models\SearchQuery;
use App\Models\StoreVisits;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Getter;
use App\Models\Store;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index(){
        return view('admin.users');
    }

    public function userDetails($id){
        $user = User::where('id',$id)->first();
        if($user){
            return view('admin.user_details')->with('user',$user);
        } else {
            return redirect()->back();
        }
    }

    public function getUsers(){
        $users = User::select('id','name','phone_no','email','city_id','created_at','referral_code')->with(array('city' => function($query){
            $query->select('city_name','id');
        }))->get();

        foreach($users as $user){
            if($user->referral_code != NULL){
                $referralType = $user->referral_code[0];
                $referralCode = $user->referral_code;
                switch ($referralType) {
                    case "S":
                        {
                            $store = Store::where('own_referral_code', $referralCode)->first();
                            $user["invited_by"] = $store->business_name;
                            break;
                        }
                    case "U":
                        {
                            $generator = User::where('own_referral_code', $referralCode)->first();
                            $user["invited_by"] = $generator->name;
                            break;
                        }
                    default:
                        {
                            $getter = Getter::where('referral_code', $referralCode)->first();
                            if($getter != null){
                                $user["invited_by"] = $getter->name;
                            } else {
                                $user["invited_by"] = "NoBody";
                            }   
                            break;
                        }
                }
            }
            else {
                $user["referral_code"] = "NoRefferal";
                $user["invited_by"] = "NoBody"; 
            }
        }

        return $users;
    }

    public function getUserOnlineTransactions($id){
        $user = User::where('id',$id)->first();
        if($user){
            return $user->online_transactons()->with(array('store'=>function($query){
                $query->select('business_name','id');
            }))->get();
        }
    }

    public function getUserOfflineTransactions($id){
        $user = User::where('id',$id)->first();
        if($user){
            return $user->transactions()->with(array('store'=>function($query){
                $query->select('business_name','id');
            }))->get();
        }
    }

    public function getSearchQueries($id){
        $searchQueries = SearchQuery::where('user_id',$id)->get();
        return $searchQueries;
    }

    public function getStoreVisits($id){
        $storeVisits = StoreVisits::where('user_id',$id)->with(array('store'=>function($query){
           $query->select('id','business_name');
        }))->get();
        return $storeVisits;
    }


}
<?php

namespace App\Http\Controllers\Store;

use App\Models\Store;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class RoyalityController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:store');
    }


    public function index(){
        $data['users'] = User::where('referral_code',Auth::guard('store')->user()->own_referral_code)->paginate(15);
        $data['totalUsers'] = User::where('referral_code',Auth::guard('store')->user()->own_referral_code)->count() + Store::where('referral_code',Auth::guard('store')->user()->own_referral_code)->count();
        $data['earnings'] = Auth::guard('store')->user()->royaltyTransactions->where('status','missing_payment')->sum('import');
        return view('store.royality_fees',$data);
    }

}

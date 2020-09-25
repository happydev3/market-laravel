<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class RoyalityController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:web');
    }

    public function index(){
        $data['users'] = User::where('referral_code',Auth::user()->own_referral_code)->paginate(12);
        $data['total_users'] = User::where('referral_code',Auth::user()->own_referral_code)->count();
        $data['total_royalty'] = Auth::user()->wallet->friends_balance;
        return view('user.royality_fees',$data);
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Models\NewsletterSubscription;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class NewsletterController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index(){
        return view('admin.newsletter_subscriptions');
    }

    public function getUsersSubscribed(){
        $users = User::select('name','email','phone_no','city_id')->where('newsletter',1)->with(array('city'=>function($q){
            $q->select('id','city_name');
        }))->get();
        return $users;
    }

    public function getExternalSubscriptions(){
        $subscriptors = NewsletterSubscription::all();
        return $subscriptors;
    }
}

<?php

namespace App\Http\Controllers\Store;

use App\Models\StoreReview;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ReviewsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:store');
    }

    public function index(){
        $store = Auth::guard('store')->user();
        $reviews = $store->reviews()->where('active',1)->orderBy('created_at','DESC')->paginate(8);
        $data['reviews'] = $reviews;
        $data['reviewsCount'] = $store->reviews->count();
        return view('store.reviews',$data);
    }
}

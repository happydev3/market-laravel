<?php

namespace App\Http\Controllers\Marketplace;

use App\Models\Product;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class FavouritesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:web');
    }

    public function index(){
        $data['favourites'] = Auth::guard('web')->user()->favourites()->paginate(12);
        return view('marketplace.user_favourites',$data);
    }

    public function addToFavourites($id){
        $product = Product::where('active',1)->where('id',$id)->firstOrFail();

        $user = Auth::guard('web')->user();
        if(!$user->favourites->contains($product)){
            $user->favourites()->attach($product);
            return redirect()->route('marketplace.favourites');
        }
        return redirect()->back();
    }

    public function removeFavourite($id){
        $product = Product::where('active',1)->where('id',$id)->firstOrFail();
        $user = Auth::guard('web')->user();
        if($user->favourites->contains($product))
            $user->favourites()->detach($product);
        return redirect()->back();
    }

}

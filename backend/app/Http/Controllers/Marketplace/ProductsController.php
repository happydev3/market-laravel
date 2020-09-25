<?php

namespace App\Http\Controllers\Marketplace;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class ProductsController extends Controller
{
    public function index(Request $request){
        $data['products'] = 0;
        $data['product_categories'] = ProductCategory::where('active',1)->get();

        if($request->query->has('lower_price') && $request->has('higher_price')){
            $data['products'] = Product::where('price','>=',Input::get('lower_price'))->where('price','<=',Input::get('higher_price'))->with(['store','multimedia'])->paginate(12);
            $data['products_count'] = Product::where('price','>=',Input::get('lower_price'))->where('price','<=',Input::get('higher_price'))->count();
        } else {
            $data['products_count'] = Product::count();
            $data['products'] = Product::with(['store','multimedia'])->paginate(15);
        }

        return view('marketplace.products',$data);
    }

    public function productDetails($slug){
        $data['product'] = Product::where('slug',$slug)->with(['multimedia','store'])->firstOrFail();

        $brutoCashback = ($data['product']->store->discount_rate/100) * ($data['product']->price);
        $data['cb_product'] = $brutoCashback - ($data['product']->store->freeback_rate/100 * $brutoCashback);

        $data['other_from_seller'] = Product::inRandomOrder()->where('store_id',$data['product']->store_id)->limit(4)->get();
        return view('marketplace.product_detail',$data);
    }

    public function productsByCategory($slug){
        $productCategory = ProductCategory::where('slug',$slug)->where('active',1)->firstOrFail();
        $data['products'] = Product::where('product_category_id',$productCategory->id)->where('active',1)->with(['store','multimedia'])->paginate(12);
        $data['products_count'] = Product::where('product_category_id',$productCategory->id)->where('active',1)->count();
        $data['product_categories'] = ProductCategory::where('active',1)->get();
        $data['category_name'] = $productCategory->name;
        return view('marketplace.products_by_category',$data);
    }
}

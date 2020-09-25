<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use function foo\func;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index(){
        return view('admin.products')->with('productsCount',Product::count());
    }

    public function getProducts(){
        $products = Product::with(array('store'=>function($query){
            $query->select('id','business_name');
        }))->with(array('multimedia' => function($query){
            $query->select('product_id','url')->where('type','web_thumb');
        }))->get();
        return $products;
    }

}

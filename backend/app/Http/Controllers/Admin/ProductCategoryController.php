<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductCategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index(){
        return view('admin.product_categories')->with('productCategoriesCount',ProductCategory::count());
    }

    public function getProductCategories(){
        $productCategories = ProductCategory::all();
        return $productCategories;
    }

    public function showEditForm($id){
        $data['productCategory'] = ProductCategory::findOrFail($id);
        return view('admin.edit_product_category',$data);
    }

    public function editProductCategory(Request $request){
        $this->validate($request,[
            'categoryName' => 'required|string',
            'categoryLang' => 'required|string',
            'categoryId' => 'required',
        ]);

        $productCategory = ProductCategory::findOrFail($request['categoryId']);
        $productCategory->name = $request['categoryName'];
        $productCategory->slug = strtolower(str_replace(" ","-",$request['categoryName']));
        $productCategory->lang = $request['categoryLang'];
        $productCategory->save();

        return redirect()->route('admin.product_categories');

    }

    public function createNewCategory(Request $request){
        $this->validate($request,[
            'categoryName' => 'required|string',
            'categoryLang' => 'required|string',
        ]);

        ProductCategory::create([
            'name' => $request['categoryName'],
            'lang' => $request['categoryLang'],
            'slug' => strtolower(str_replace(" ","-",$request['categoryName'])),
            'active' => 1,
        ]);

        return redirect()->back();
    }

    public function switchCategoryState($id){  //Enables or Disables a Category
        $productCategory = ProductCategory::findOrFail($id);

        if($productCategory->active == 1){
            $productCategory->active = 0;
            $productCategory->save();

            $products = Product::where('product_category_id',$productCategory->id)->get();
            $genericCategory = ProductCategory::where('name','Generic')->firstOrFail();

            foreach($products as $p){
                $p->product_category_id = $genericCategory->id;
                $p->save();
            }
        }
        else {
            $productCategory->active = 1;
            $productCategory->save();
        }

        return redirect()->back();
    }

}

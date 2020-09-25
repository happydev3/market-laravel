<?php

namespace App\Http\Controllers\Admin;

use App\Models\Store;
use App\Models\StoreCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StoreCategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index(){
        return view('admin.store_categories')->with('storeCategoriesCount',StoreCategory::count());
    }

    public function getStoreCategories(){
        $storeCategories = StoreCategory::all();
        return $storeCategories;
    }

    public function switchStoreCategoryState($id){

        $storeCategory = StoreCategory::findOrFail($id);
        if($storeCategory->active == 1){
            $storeCategory->active = 0;

            $storesInCategory = Store::where('store_category_id',$storeCategory->id)->get();
            $genericStoreCategory = StoreCategory::where('name','Generic')->firstOrFail();
            foreach($storesInCategory as $s){
                $s->store_category_id = $genericStoreCategory->id;
                $s->save();
            }
            $storeCategory->save();
        } else {
            $storeCategory->active = 1;
            $storeCategory->save();
        }
        return redirect()->back();
    }

    public function showStoreCategoryEditForm($id){
        return view('admin.store_category_edit')->with('storeCategory',StoreCategory::findOrFail($id));
    }

    public function createStoreCategory(Request $request){

        $this->validate($request,[
            'categoryName' => 'required|string',
            'categoryLang' => 'required|string',
        ]);

        StoreCategory::create([
            'name' => $request['categoryName'],
            'lang' => $request['categoryLang'],
            'slug' => strtolower(str_replace(" ","-",$request['categoryName'])),
            'active'=>1,
        ]);

        return redirect()->back();
    }

    public function updateStoreCategory(Request $request){

        $this->validate($request,[
            'categoryName' => 'required|string',
            'categoryLang' => 'required|string',
            'storeCategoryId' => 'required',
        ]);

        $storeCategory = StoreCategory::findOrFail($request['storeCategoryId']);
        $storeCategory->name = $request['categoryName'];
        $storeCategory->slug = strtolower(str_replace(" ","-",$request['categoryName']));
        $storeCategory->lang = $request['categoryLang'];
        $storeCategory->save();


        return redirect()->route('admin.store_categories');

    }




}

<?php

namespace App\Http\Controllers\Store;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\ProductCategory;
use App\Http\Controllers\Controller;
use App\Models\ProductMultimedia;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Input;
use Auth;
use Illuminate\Support\Facades\URL;
use Intervention\Image\ImageManagerStatic as Image;


class ProductsController extends Controller
{

    const DEFAULT_WEB_THUMB = "images/defaults/product_small.png";
    const DEFAULT_FRONT_IMG = "images/defaults/product_big.png";

    public function __construct()
    {
        $this->middleware('auth:store');
    }

    public function newProduct(){
        $data['product_categories'] = ProductCategory::where('active',1)->orderBy('name','ASC')->get();
        return view('store.new_product',$data);
    }

    public function manageProducts(){
        $products = Auth::guard('store')->user()->products()->paginate(15);
        return view('store.manage_products')->with('products',$products);
    }

    public function createProduct(Request $request){

        $this->validate($request,[
            'product_category' => 'required|numeric|min:0',
            'title' => 'required|string|min:1',
            'description' => 'required|string',
            'price' => 'required|numeric|min:1',
            'qta' => 'required|numeric|min:1',
            'currency' => 'in:$,£,€',
        ]);

        $product = new Product();
        $product->title = Input::get('title');
        $product->store_id = Auth::guard('store')->user()->id;
        $product->description =  Input::get('description');
        $product->product_category_id = Input::get('product_category',0);
        $product->price = Input::get('price',0.00);
        $product->currency = Input::get('currency','€');
        $product->quantity_available = Input::get('qta',0);
        $product->redirect_url = Input::get('url','#');
        $product->slug = $this->generateProductSlug($product->title, Auth::guard('store')->user()->business_name);
        $product->loaded_by = "vendor";
        $product->store_internal_code = Input::get('internal_code','NO_CODE');
        $product->save();

        if(isset($request['front_img'])){
            $front_img = $request->file('front_img');
            $dest_path = 'uploads/images/products/';
            $filename = str_random(15)."_.".$front_img->getClientOriginalExtension();
            $filename_copy = str_random(14)."_img.".$front_img->getClientOriginalExtension();

            $front_img->move($dest_path,$filename);
            File::copy($dest_path.$filename,$dest_path.$filename_copy);

            Image::make($dest_path.$filename)->fit(258,150)->save($dest_path.$filename);

            Image::make($dest_path.$filename_copy)->resize(838,486,function ($constraint){
                $constraint->aspectRatio();
            })->resizeCanvas(838,486)->save($dest_path.$filename_copy);


            ProductMultimedia::create([
                'type' => 'web_thumb',
                'product_id' => $product->id,
                'url'=> $dest_path.$filename,
            ]);

            if(!isset($request['product_images'])){
                ProductMultimedia::create([
                    'type' => 'image',
                    'product_id' => $product->id,
                    'url'=> $dest_path.$filename_copy,
                ]);
            }

        }
        else {
            ProductMultimedia::create([
                'type' => 'web_thumb',
                'product_id' => $product->id,
                'url'=> self::DEFAULT_WEB_THUMB,
            ]);

        }

        if(isset($request['product_images'])){
            foreach($request->file('product_images') as $image){
                if(!empty($image)){
                    $dest_path = 'uploads/images/products/';
                    $filename = str_random(25).".".$image->getClientOriginalExtension();
                    $image->move($dest_path,$filename);
                    ProductMultimedia::create([
                        'type' => 'image',
                        'product_id' => $product->id,
                        'url' => $dest_path.$filename,
                    ]);
                    Image::make($dest_path.$filename)->resize(838,486,function ($constraint){
                        $constraint->aspectRatio();
                    })->resizeCanvas(838,486)->save($dest_path.$filename);
                }
            }
        }
        else{
            ProductMultimedia::create([
                'type' => 'image',
                'product_id' => $product->id,
                'url' => self::DEFAULT_FRONT_IMG,
            ]);
        }
        return redirect()->route('store.products');
    }

    public function edit_product($id){
        $product = Product::where('id',$id)->first();
        if(($product and  $product->loaded_by == "vendor") && ($product->store_id  == Auth::guard('store')->user()->id && ($product->active == 1))){
            $data['product'] = $product;
            $data['product_categories'] = ProductCategory::where('active',1)->get();
            return view('store.edit_product',$data);
        }
    }

    public function editProductMultimedia($id){
        $store = Auth::guard('store')->user();
        $product = $store->products()->where('id',$id)->where('active',1)->firstOrFail();

        if($product->loaded_by == "vendor"){
            $data['multimedia'] = $product->multimedia->where('type','image')->all();
            $data['product_id'] = $product->id;
            $data['front_img'] = $product->multimedia->where('type','web_thumb')->first();
            return view('store.edit_product_images',$data);
        }
        else return redirect()->back();
    }

    public function disable_priduct($id){
        $product = Product::findOrFail($id);
        if(($product)  && ($product->loaded_by == "vendor") && ($product->store->id == Auth::guard('store')->user()->id)){
            $product->active = 0;
            $product->save();
        }
        return redirect()->back();
    }

    public function enableProduct($id){
        $product = Product::findOrFail($id);
        if($product->store_id == Auth::guard('store')->user()->id){
            $product->active = 1;
            $product->save();
        }
        return redirect()->back();
    }




    private function generateProductSlug($productTitle, $store){
         return str_replace(" ","-",$productTitle).
            "-cashback-".str_replace(" ","-",$store).
            "-".str_random(10);
    }


}

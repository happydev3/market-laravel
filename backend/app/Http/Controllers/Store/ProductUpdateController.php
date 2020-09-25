<?php

namespace App\Http\Controllers\Store;

use App\Models\Product;
use App\Models\ProductMultimedia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Input;
use Intervention\Image\ImageManagerStatic as Image;

class ProductUpdateController extends Controller
{

    const DEFAULT_WEB_THUMB = "images/defaults/product_small.png";
    const DEFAULT_FRONT_IMG = "images/defaults/product_big.png";


    public function __construct()
    {
        $this->middleware('auth:store');
    }


    public function edit_product(Request $request){

        $this->validate($request,[
            'product_category' => 'required|numeric|min:0',
            'title' => 'required|string|min:1',
            'description' => 'required|string',
            'price' => 'required|numeric|min:1',
            'qta' => 'required|numeric|min:1',
            'currency' => 'in:$,£,€',
        ]);

        $product = Product::where('id',Input::get('product_id'))->first();
        if($product->store->id != Auth::guard('store')->user()->id){
            abort(404);
        }

        $product->title = Input::get('title','');
        $product->description = Input::get('description','');
        $product->price = Input::get('price',0);
        $product->quantity_available = Input::get('qta',0);
        $product->currency = Input::get('currency','€');
        $product->product_category_id = Input::get('product_category',1);
        $product->redirect_url = Input::get('url','#');
        $product->save();

        return redirect()->route('store.products');

    }

    public function editWebThumb(Request $request){
        if($request->hasFile('front-img')){
            if($request->has('product_id')){  //THIS MEANS THAT THE PRODUCT IN THE CONTEXT DOESEN'T HAVE A FRONT IMAGE, AND THE CODE BELOW CREATES IT
                $front_img = $request->file('front-img');
                $dest_path = 'uploads/images/products/';
                $filename = str_random(15)."_.".$front_img->getClientOriginalExtension();
                $front_img->move($dest_path,$filename);

                Image::make($dest_path.$filename)->fit(258,150)->save($dest_path.$filename);

                $productFronts = ProductMultimedia::where('product_id',$request['product_id'])->where('type','web_thumb')->get();
                foreach($productFronts as $p){
                    if($p->url != self::DEFAULT_WEB_THUMB){
                        File::delete($p->url);
                    }
                    ProductMultimedia::destroy($p->id);
                }

                ProductMultimedia::create([
                    'type' => 'web_thumb',
                    'product_id' => $request['product_id'],
                    'url'=> $dest_path.$filename,
                ]);
            }
        }

        return redirect()->back();

    }


    public function upload_other_images(Request $request){
        if(isset($request['product_new_images'])){
            foreach($request->file('product_new_images') as $image){
                if(!empty($image)){
                    $dest_path = 'uploads/images/products/';
                    $filename = str_random(25).".".$image->getClientOriginalExtension();
                    $image->move($dest_path,$filename);
                    ProductMultimedia::create([
                        'type' => 'image',
                        'product_id' => $request['product_id'],
                        'url' => $dest_path.$filename,
                    ]);
                    Image::make($dest_path.$filename)->resize(838,486,function ($constraint){
                        $constraint->aspectRatio();
                    })->resizeCanvas(838,486)->save($dest_path.$filename);
                }
            }
            $defaultPicture = ProductMultimedia::where('url',self::DEFAULT_FRONT_IMG)->get();
            foreach($defaultPicture as $d){
                $d->delete();
            }
        }

        $toDelete = Auth::guard('store')->user()->products->where('id',$request['product_id'])->first()->multimedia->where('url',self::DEFAULT_FRONT_IMG)->first();
        if($toDelete){
            $toDelete->delete();
        }

        return redirect()->back();
    }

    public function deleteProductImage($multimedia_id){
        $store = Auth::guard('store')->user();
        $multimediaItem = ProductMultimedia::where('id', $multimedia_id)->firstOrFail();

        if($store->id == $multimediaItem->product->store->id) {
            if($multimediaItem->type == "web_thumb"){
                if($multimediaItem->url != self::DEFAULT_WEB_THUMB){
                    File::delete($multimediaItem->url);
                    $multimediaItem->delete();
                    ProductMultimedia::create([
                        'type' => 'web_thumb',
                        'product_id' => $multimediaItem->product->id,
                        'url' => self::DEFAULT_WEB_THUMB
                    ]);
                }
            }

            if($multimediaItem->type == "image"){
                if($multimediaItem->url != self::DEFAULT_FRONT_IMG){
                    File::delete($multimediaItem->url);
                    $product = $multimediaItem->product;
                    $multimediaItem->delete();
                    if(ProductMultimedia::where('product_id',$product->id)->where('type','image')->count() < 1){
                        ProductMultimedia::create([
                            'type' => 'image',
                            'product_id' => $multimediaItem->product->id,
                            'url' => self::DEFAULT_FRONT_IMG,
                        ]);
                    }
                }
            }
        }
        return redirect()->back();
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Models\StoreCategory;
use App\Models\TDStore;
use App\Models\TdStoreDiscount;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManagerStatic as Image;

class TradeDoublerController extends Controller
{
    const TD_STORE_PHOTO_PATH = "uploads/images/tradedoubler/";

    const STORE_LANDING_IMG_HEIGHT = 300;
    const STORE_LANDING_IMG_WIDTH  = 1500;

    const STORE_LOGO_WIDTH = 80;
    const STORE_LOGO_HEIGHT = 80;


    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index(){
        $storeCategories = StoreCategory::where('active',1)->get();
        return view('admin.trade_doubler')->with('storeCategories',$storeCategories);
    }

    public function switchStoreState($id){
        $tdStore = TDStore::where('id',$id)->firstOrFail();
        if($tdStore->active == 1) {
            $tdStore->active = 0;
        } else {
            $tdStore->active = 1;
        }

        $tdStore->save();
        return redirect()->back();
    }

    public function editStore($id){
        $data['tdStore'] = TDStore::where('id',$id)->firstOrFail();
        $data['storeCategories'] = StoreCategory::where('active',1)->get();
        return view('admin.edit_td_store',$data);
    }

    public function createTdStore(Request $request){
        $this->validate($request,[
            'store_name' => 'required|string',
            'email' => 'nullable|email',
            'front_thumbnail' => 'required|image',
            'logo' => 'required|image',
            'background_img' => 'required|image',
            'tracking_time' => 'required|in:day,week,month,3month',
            'credit_time' => 'required|in:day,week,month,3month',
            'description' => 'string',
            'store_category' => 'required|numeric',
            'target_url' => 'required|string',
            'cashback' => 'required|numeric',
            'program_id' => 'required|numeric',
        ]);

        $td = new TDStore();
        $td->name = $request['store_name'];
        $td->email = $request['email'];
        $td->tracking_time = $request['tracking_time'];
        $td->credit_time = $request['credit_time'];
        $td->front_thumbnail = $this->saveAndResizeImage($request->file("front_thumbnail"));
        $td->bg_image = $this->saveAndResizeBackgroundImage($request->file('background_img'));
        $td->logo = $this->saveAndResizeLogo($request->file('logo'));
        $td->cashback = $request['cashback'];
        $td->store_category_id = $request['store_category'];
        $td->target_url = $this->webUrl($request['target_url']);
        $td->slug = $this->generateSlug($request['store_name']);
        $td->store_description = $request['description'];
        $td->program_id = $request['program_id'];
        $td->active = 1;
        $td->save();

        return redirect()->back();

    }


    public function getStoreDiscounts($id){
        $discounts = TdStoreDiscount::where('t_d_store_id',$id)->get();
        return $discounts;
    }

    public function newStoreDiscount($id){
        $tdStore = TDStore::where('id',$id)->firstOrFail();
        return view('admin.new_td_discount')->with('tdStore',$tdStore);
    }

    public function editStoreDiscount($id){
        $tdDiscount = TdStoreDiscount::where('id',$id)->firstOrFail();
        return view('admin.edit_td_discount')->with('tdDiscount',$tdDiscount);
    }

    public function editStoreDiscountSubmit(Request $request){
        $this->validate($request,[
            'category' => 'required|string',
            'cashback' => 'required|numeric',
            'tdDiscountId' => 'required|numeric',
        ]);

        $tdDiscount = TdStoreDiscount::where('id',$request['tdDiscountId'])->firstOrFail();
        $tdDiscount->category = $request['category'];
        $tdDiscount->cashback = $request['cashback'];
        $tdDiscount->save();

        return redirect()->route('admin.edit_tradedoubler',['id' => $tdDiscount->t_d_store_id]);
    }

    public function switchDiscountStatus($id){
        $discount = TdStoreDiscount::where('id',$id)->firstOrFail();
        if($discount->active == 1) {
            $discount->active = 0;
        } else {
            $discount->active = 1;
        }
        $discount->save();
        return redirect()->back();
    }

    public function createStoreDiscount(Request $request){
        $this->validate($request,[
            'tdStoreId' => 'required|numeric',
            'category' => 'required|string',
            'cashback' => 'required|numeric',
        ]);

        $tdStore = TDStore::where('id',$request['tdStoreId'])->firstOrFail();
        TdStoreDiscount::create([
            'category' => $request['category'],
            'cashback' => $request['cashback'],
            't_d_store_id' => $tdStore->id,
            'active' => 1,
        ]);

        return redirect()->route('admin.edit_tradedoubler',['id'=>$tdStore->id]);
    }


    public function updateTradeDoublerStore(Request $request){
        $this->validate($request,[
            'store_id' => 'required|numeric',
            'program_id' => 'required|numeric',
            'store_name' => 'required|string',
            'email' => 'nullable|email',
            'front_thumbnail' => 'image',
            'logo' => 'image',
            'background_img' => 'image',
            'tracking_time' => 'required|in:day,week,month,3month',
            'credit_time' => 'required|in:day,week,month,3month',
            'description' => 'string',
            'store_category' => 'required|numeric',
            'target_url' => 'required|string',
            'cashback' => 'required|numeric',
        ]);

        $td = TDStore::where('id',$request['store_id'])->firstOrFail();
        $td->name = $request['store_name'];
        $td->email = $request['email'];
        $td->program_id = $request['program_id'];
        $td->tracking_time = $request['tracking_time'];
        $td->credit_time = $request['credit_time'];

        $td->cashback = $request['cashback'];
        $td->store_category_id = $request['store_category'];
        $td->target_url = $this->webUrl($request['target_url']);
        $td->store_description = $request['description'];

        if($request->has("front_thumbnail")) {
            $newThumbnail = $this->saveAndResizeImage($request->file("front_thumbnail"));
            File::delete($td->front_thumbnail);
            $td->front_thumbnail = $newThumbnail;
        }

        if($request->has('background_img')){
            $newBg = $this->saveAndResizeBackgroundImage($request->file("background_img"));
            File::delete($td->bg_image);
            $td->bg_image = $newBg;
        }

        if($request->has('logo')) {
            $newLogo = $this->saveAndResizeLogo($request->file("logo"));
            File::delete($td->logo);
            $td->logo = $newLogo;
        }

        $td->save();
        return redirect()->back();
    }


    public function getTdStores(){
        $td = TDStore::all();
        return $td;
    }

    private function saveAndResizeImage($image){
        $filename = str_random(15).".".$image->getClientOriginalExtension();
        $image->move(self::TD_STORE_PHOTO_PATH,$filename);
        Image::make(self::TD_STORE_PHOTO_PATH.$filename)->fit(258,150)->save(self::TD_STORE_PHOTO_PATH.$filename);
        return self::TD_STORE_PHOTO_PATH.$filename;
    }

    private function saveAndResizeBackgroundImage($image){
        $filename = str_random(15).".".$image->getClientOriginalExtension();
        $image->move(self::TD_STORE_PHOTO_PATH,$filename);
        Image::make(self::TD_STORE_PHOTO_PATH.$filename)->fit(self::STORE_LANDING_IMG_WIDTH,self::STORE_LANDING_IMG_HEIGHT,function($constraint){
            $constraint->aspectRatio();
        })->resizeCanvas(self::STORE_LANDING_IMG_WIDTH,self::STORE_LANDING_IMG_HEIGHT,'center',false,"#ffffff")->save(self::TD_STORE_PHOTO_PATH.$filename);;
        return self::TD_STORE_PHOTO_PATH.$filename;
    }

    private function saveAndResizeLogo($image){
        $filename = str_random(15).".".$image->getClientOriginalExtension();
        $path =  $image->move(self::TD_STORE_PHOTO_PATH,$filename);
        Image::make($path)->resize(self::STORE_LOGO_WIDTH,self::STORE_LOGO_HEIGHT,function($constraint){
            $constraint->aspectRatio();
        })->resizeCanvas(self::STORE_LOGO_WIDTH,self::STORE_LOGO_HEIGHT,'center',false,array(0,0,0,0))->save($path);;
        return $path;
    }

    private function webUrl($url){
        if(substr($url,0,4) == "http"){
            return $url;
        } else
            return "http://".$url;
    }

    private function generateSlug($storeName){
        return str_replace(" ","_",$storeName). "-cashback-freeback-".str_random(10);
    }
}

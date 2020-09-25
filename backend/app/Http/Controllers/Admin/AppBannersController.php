<?php

namespace App\Http\Controllers\Admin;

use App\Models\MarketingBanner;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AppBannersController extends Controller
{
    const DEFAULT_APP_BANNERS_PATH = 'uploads/images/marketing/';
    const APP_URL = "https://www.freeback.it/";


    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index(){
        return view('admin.app_banners');
    }

    public function getAppBanenrs(){
        $marketingBanners = MarketingBanner::all();
        return $marketingBanners;
    }

    public function switchBanenrState($id){
        $marketingBanner = MarketingBanner::findOrFail($id);
        if($marketingBanner->active == 1){
            $marketingBanner->active = 0;
        } else {
            $marketingBanner->active = 1;
        }

        $marketingBanner->save();
        return redirect()->back();
    }

    public function createBanner(Request $request){

        $this->validate($request,[
            'bannerText' => 'string|required',
            'bannerBackground' => 'required|file',
        ]);

        $bannerImg = $request->file('bannerBackground');
        $fileName = str_random(20).".".$bannerImg->getClientOriginalExtension();
        $path = $bannerImg->move(self::DEFAULT_APP_BANNERS_PATH,$fileName);
        $path = str_replace('\\',"/",$path);
        MarketingBanner::create([
            'background_url'=>self::APP_URL.$path,
            'text' => $request['bannerText'],
            'active' => 1,
        ]);

        return redirect()->back();
    }
}

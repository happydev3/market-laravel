<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\URL;

class MarketingController extends Controller
{
    public function app_home_first(){
        $urls = [
            [
                'id' => 1,
                'img_url' => 'images/marketing/marketing6.png',
                'target_url' => 'target1',
            ],

            [
                'id' => 2,
                'img_url' => 'images/marketing/marketing1.png',
                'target_url' => 'target2',
            ],

            [
                'id' => 3,
                'img_url' => 'images/marketing/marketing3.png',
                'target_url' => 'target3',
            ],

        ];

        return response()->json($urls,200,[]);
    }


    public function bottom_ads(){
        $urls = [
            [
                'id' => 1,
                'img_url' => 'images/marketing/marketing4.png',
                'target_url' => 'target1',
            ],

            [
                'id' => 2,
                'img_url' => 'images/marketing/marketing6.png',
                'target_url' => 'target2',
            ],

            [
                'id' => 3,
                'img_url' => 'images/marketing/marketing5.png',
                'target_url' => 'target3',
            ],

        ];

        return response()->json($urls,200,[]);
    }
}

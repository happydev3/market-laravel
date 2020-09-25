<?php

namespace App\Http\Controllers\Marketplace;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class LocaleController extends Controller
{
    public function set_locale($locale){

        if($locale == "it" or $locale == "en"){
            Session::put('locale',$locale);
        }
        return redirect()->back();
    }
}

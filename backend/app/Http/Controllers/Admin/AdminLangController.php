<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class AdminLangController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function setLocale($locale){
        if($locale == "it" or $locale == "en"){
            Session::put('locale',$locale);
        }

        return redirect()->back();
    }
}

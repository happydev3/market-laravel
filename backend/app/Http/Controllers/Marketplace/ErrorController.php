<?php

namespace App\Http\Controllers\Marketplace;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ErrorController extends Controller
{
    public function error404(){
        return view('errors.404');
    }
}

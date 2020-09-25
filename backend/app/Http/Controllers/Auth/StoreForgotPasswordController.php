<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Password;

class StoreForgotPasswordController extends Controller
{
    use SendsPasswordResetEmails;

    public function __construct()
    {
        $this->middleware('guest');
    }


    protected function broker(){
        return Password::broker('stores');
    }

    public function showLinkRequestForm()
    {
        return view('auth.passwords.store_email');
    }


}

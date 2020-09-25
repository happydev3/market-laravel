<?php

namespace App\Http\Controllers\Marketplace;

use App\Models\Faq;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\File;

class InfoController extends Controller
{
    public function cookies(){
        return view('marketplace.legal.cookie_policy');
    }

    public function faq(){
        $data['faqs'] = Faq::where('active',1)->get();
        return view('marketplace.legal.faq',$data);
    }

    public function jobs(){
        return view('marketplace.legal.jobs');
    }

    public function joinUs(){
        return view('marketplace.legal.join_us');
    }

    public function forUsers(){
        return view('marketplace.legal.for_users');
    }

    public function forVendors(){
        return view('marketplace.legal.for_vendors');
    }

    public function privacy(){
        return view('marketplace.legal.privacy_pollicy');
    }

    public function terms(){
        return view('marketplace.legal.terms');
    }

    public function rejectRight(){
        return view('marketplace.legal.reject');
    }

    public function sellerContract(){
        return response()->download("documents/contratto_venditore_freeback.pdf");
    }

    public function accessConditions(){
        return response()->download("documents/condizioni_di_accesso_freeback.pdf");
    }

    public function sellingConditions(){
        return response()->download("documents/condizioni_di_vendita_freeback.pdf");
    }


}

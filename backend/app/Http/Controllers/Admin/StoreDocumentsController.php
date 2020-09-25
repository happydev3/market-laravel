<?php

namespace App\Http\Controllers\Admin;

use App\Mail\StoreDocumentNotValid;
use App\Models\StoreDocument;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;

class StoreDocumentsController extends Controller
{
    public function  __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index(){
        return view('admin.store_documents');
    }

    public function getDocuments(){
        $storeDocuments = StoreDocument::with(array('store'=>function($q){
            $q->select('id','business_name');
        }))->get();

        return $storeDocuments;
    }

    public function acceptDocument($id){
        $storeDocument = StoreDocument::findOrFail($id);
        $storeDocument->valid = 1;
        $storeDocument->save();
        return redirect()->back();
    }

    public function declineDocument($id){
        $storeDocument = StoreDocument::findOrFail($id);
        File::delete($storeDocument->document_url);
        $store = $storeDocument->store;
        $storeDocument->delete();
        Mail::to($store->email)->send(new StoreDocumentNotValid($store->business_name));
        return redirect()->back();
    }

}

<?php

namespace App\Http\Controllers\Store;

use App\Mail\StoreDocumentsRecieved;
use App\Models\StoreDocument;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class StoreDocumentsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:store');
    }

    public function index(){

        $store = Auth::guard('store')->user();
        $data['chamberDocument'] = $store->documents->where('type','v_camerale')->first();
        $data['idDocument'] = $store->documents->where('type','id')->first();
        $data['piva'] = $store->documents->where('type','piva')->first();

        return view('store.documents',$data);
    }

    public function upload_documents(Request $request){

        $this->validate($request,[
            'chamber_document' => 'file',
            'owner_id_doc' => 'file',
            'vat_document' => 'file',
        ]);


        if(isset($request['chamber_document'])) {
            $chamberDocument = $request->file('chamber_document');
            $fileName = "private/doc_chamber_" . Auth::guard('store')->user()->id . "_" . str_random(10) . "." . $chamberDocument->getClientOriginalExtension();
            Storage::put($fileName, file_get_contents($chamberDocument));

            StoreDocument::create([
                'store_id' => Auth::guard('store')->user()->id,
                'document_url' => "backend/storage/app/" . $fileName,
                'type' => 'v_camerale',
            ]);
        }

        if(isset($request['owner_id_doc'])) {
            $idDoc = $request->file('owner_id_doc');
            $fileName = "private/id_doc_" . Auth::guard('store')->user()->id . "_" . str_random(10) . "." . $idDoc->getClientOriginalExtension();
            Storage::put($fileName, file_get_contents($idDoc));

            StoreDocument::create([
                'store_id' => Auth::guard('store')->user()->id,
                'document_url' => "backend/storage/app/" . $fileName,
                'type' => 'id',
            ]);
        }

        if(isset($request['vat_document'])) {
            $vatDocument = $request->file('vat_document');
            $fileName = "private/vat_document_" . Auth::guard('store')->user()->id . "_" . str_random(10) . "." . $vatDocument->getClientOriginalExtension();
            Storage::put($fileName, file_get_contents($vatDocument));

            StoreDocument::create([
                'store_id' => Auth::guard('store')->user()->id,
                'document_url' => "backend/storage/app/" . $fileName,
                'type' => 'piva',
            ]);
        }

        Mail::to(Auth::guard('store')->user()->email)->send(new StoreDocumentsRecieved(Auth::guard('store')->user()->business_name));
        return redirect()->back();

    }
}

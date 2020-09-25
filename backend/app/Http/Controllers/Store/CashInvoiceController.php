<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\CashTransaction;
use Illuminate\Support\Facades\Auth;
use PDF;

class CashInvoiceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:store');
    }

    public function index(){
        $storeUser = Auth::guard('store')->user();
        $data['invoices'] = $storeUser->cashInvoices()->where('valid',1)->orderBy('created_at','DESC')->paginate(15);
        $data['totalInvoices'] =$storeUser->cashInvoices()->where('valid',1)->count();

        return view('store.cash_invoices',$data);
    }

    public function downloadInvoice($id){
        $data['invoice'] = Auth::guard('store')->user()->cashInvoices()->where('id',$id)->firstOrFail();
        $data['transactions'] = CashTransaction::where('cash_invoice_id',$data['invoice']->id)->where('status','accepted')->get();
        $data['sum'] = 0;
        $data['clearSum'] = 0;
        $data['vatSum'] = 0;
        $data['totalSum'] = 0;


        foreach($data['transactions'] as $t) {
            $data['sum'] += $t->full_import;
            $data['clearSum'] += ($t->cashback_neto/1.22) + ($t->freeback_neto/1.22);
            $data['vatSum'] += (($t->freeback_neto - $t->freeback_neto/1.22) + ($t->cashback_neto - $t->cashback_neto/1.22));
            $data['totalSum'] += $t->freeback_neto + $t->cashback_neto;
        }

        $pdf = PDF::loadView('invoices.cash_invoice',$data);
        return $pdf->download("Fattura_Cash_".$data['invoice']->invoice_number.".pdf");
    }
}

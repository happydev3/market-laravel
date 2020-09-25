<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\CashInvoice;
use App\Models\CashTransaction;
use App\Models\OnlineTransaction;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use PDF;


class InvoiceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:store');
    }

    public function index(){
        $storeUser = Auth::guard('store')->user();
        $data['invoices'] = $storeUser->invoices()->where('valid',1)->orderBy('created_at','DESC')->paginate(15);
        $data['totalInvoices'] = $storeUser->invoices()->where('valid',1)->count();
        return view('store.invoices',$data);
    }

    public function downloadInvoice($invoice_id){
        $data['invoice'] = Auth::guard('store')->user()->invoices()->where('id',$invoice_id)->firstOrFail();
        if($data['invoice']->transaction_type == "online") {
            $data['transactions'] = OnlineTransaction::where('invoice_id',$data['invoice']->id)->where('status','completed')->get();
        } else if($data['invoice']->transaction_type == "offline") {
            $data['transactions'] = Transaction::where('invoice_id',$data['invoice']->id)->where('status','completed')->get();
        }

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

        $pdf = PDF::loadView('invoices.store_invoice',$data);
        return $pdf->download("Fattura_Web_".$data['invoice']->invoice_number.".pdf");
    }

}

<?php

namespace App\Http\Controllers\User;

use App\External\DropPayService;
use App\Mail\StoreOrderNotify;
use App\Models\Invoice;
use App\Models\OnlineTransaction;
use App\Models\Order;
use App\Models\OrderShippingAddress;
use App\Models\Product;
use App\Models\Store;
use App\Models\StoreNotification;
use App\Models\UserNotification;
use App\Models\UserWallet;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Mail;

class OnlineOrderController extends Controller
{

    private $dropPay;

    public function __construct()
    {
        $this->middleware('auth:web');
        $this->dropPay = new DropPayService();
    }

    public function createOnlineOrder(Request $request){

        $this->validate($request,[
            'product_id' => 'required|numeric',
            'product_quantity' => 'required|numeric',
            'name' => 'required|string',
            'address' => 'required|string',
            'house_number' => 'required|string',
            'zip_code' => 'required|string',
            'country' => 'required|numeric',
            'city' => 'required|string',
            'notes' => 'nullable|string',
            'invoice_details' => 'nullable|string',
        ]);



        $shipping_address = new OrderShippingAddress();
        $shipping_address->name = Input::get('name');
        $shipping_address->address = Input::get('address');
        $shipping_address->house_number = Input::get('house_number');
        $shipping_address->zip_code = Input::get('zip_code');
        $shipping_address->country_id = Input::get('country');
        $shipping_address->city = Input::get('city');
        $shipping_address->additional_notes = Input::get('notes',null);

        if(isset($request['same_add'])){
            $shipping_address->invoice_same_address = 1;
        } else {
            $shipping_address->invoice_details = Input::get('invoice_details',null);
        }

        $shipping_address->order_id = 1; // Temporary Value
        $shipping_address->save();

        $product = Product::where('id',$request['product_id'])->firstOrFail();
        $store = Store::where('id',$product->store_id)->firstOrFail();

        if($product->sellable()){
            $brutoCashback = $this->cashbackOnTotal($product,$store,$request['product_quantity']);
            $freebackFee = $this->freebackFee($brutoCashback,$store);
            $netoCashback = $brutoCashback - $this->freebackFee($brutoCashback,$store);
            $fullImport = $product->price * $request['product_quantity'];

            $transaction_id = $this->makeTransaction($store, $fullImport, $netoCashback,$freebackFee);

            $order = new Order();
            $order->online_transaction_id = $transaction_id;
            $order->user_id = Auth::guard('web')->user()->id;
            $order->store_id = $store->id;
            $order->product_id = $product->id;
            $order->product_quantity = $request['product_quantity'];
            $order->disputable_until = Carbon::now()->addDays(15)->format('y-m-d');
            $order->order_shipping_addresses_id = $shipping_address->id;
            $order->save();

            $shipping_address->order_id = $order->id;
            $shipping_address->save();

            $transaction = OnlineTransaction::where('id',$transaction_id)->first();
            $transaction->order_id = $order->id;
            $transaction->save();


            return  view('marketplace.complete_online_order')->with('pullId',$transaction->dp_pull_id);
        }
        else return redirect()->back();
    }


    private function cashbackOnTotal($product,$store,$productQuantity){
        return ($store->discount_rate/100) * ($product->price*$productQuantity);
    }

    private function freebackFee($cashback, $store){
        return ($store->freeback_rate/100) * $cashback;
    }

    private function makeTransaction($store,$fullImport,$cashbackNeto,$freebackNeto){
        $transaction = new OnlineTransaction();
        $transaction->user_id = Auth::guard('web')->user()->id;
        $transaction->store_id = $store->id;
        $transaction->full_import = $fullImport;
        $transaction->discount_rate = $store->discount_rate;
        $transaction->freeback_rate = $store->freeback_rate;
        $transaction->cashback_neto = $cashbackNeto;
        $transaction->freeback_neto = $freebackNeto;
        $transaction->dp_pull_id = $this->dropPay->createPullRequestByStore($store->paymentConfiguration->dp_connection_code,$transaction->full_import,$store->business_name);
        $transaction->save();
        return $transaction->id;
    }

    public function createInvoice($transaction){
        $invoice = new Invoice();
        $invoice->invoice_number = Invoice::max('invoice_number') + 1;
        $invoice->date = Carbon::now()->format('20y-m-d');
        $invoice->invoice_type = "transaction_invoice";
        $invoice->transaction_type = "online";
        $invoice->transaction_id = $transaction->id;
        $invoice->store_id = $transaction->store_id;
        $invoice->freeback_fee = $transaction->freeback_neto;
        $invoice->cashback_fee = $transaction->cashback_neto;
        $invoice->total = $invoice->freeback_fee + $invoice->cashback_fee;
        $invoice->save();
    }

    public function orderCompletedSuccess(){
        return view('marketplace.order_done');
    }

    public function orderError(){
        return view('marketplace.order_error');
    }

    public function checkTransactionStatus($pullId){
        $transaction = OnlineTransaction::where('dp_pull_id',$pullId)->firstOrFail();
        return ["status"=>$transaction->status];
    }
}

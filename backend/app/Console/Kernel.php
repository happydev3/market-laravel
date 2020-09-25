<?php

namespace App\Console;

use App\External\DropPayService;
use App\Models\CashInvoice;
use App\Models\CashTransaction;
use App\Models\DropPayConfiguration;
use App\Models\FeesInfo;
use App\Models\Getter;
use App\Models\GetterTransaction;
use App\Models\Invoice;
use App\Models\OnlineTransaction;
use App\Models\PhoneVerifySms;
use App\Models\Store;
use App\Models\StoreReferralTransaction;
use App\Models\Transaction;
use App\Models\User;
use function foo\func;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\File;
use jobayerccj\Skebby\Skebby;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        //Test on Scheduler
        $schedule->call(function (){
            File::put('schedule.txt','Called at'.Carbon::now());
        })->everyMinute();

        //Send SMS to Verify Phone
        $schedule->call(function(){
            $toSend = PhoneVerifySms::where('status','waiting')->get();
            foreach($toSend as $sms){
                $skebby = new Skebby;
                $skebby->set_username('bluerockltd');
                $skebby->set_password('bluerock2018');
                $skebby->set_method('send_sms_classic');
                $skebby->set_text($sms->text);
                $skebby->set_sender('3356098390');
                $recipients = array($sms->phone_number);
                $skebby->set_recipients($recipients);
                $status = $skebby->send_sms();
                if($status['status'] == "success"){

                    $sms->status = "sent";
                } else {
                    $sms->status = "error";
                }
                $sms->save();
            }
        })->everyMinute();

        $schedule->call(function(){
            $toInvoiceOnline = OnlineTransaction::where('status','completed')->where('invoiced',0)->get();
            foreach($toInvoiceOnline as $t){
                $invoice = new Invoice();
                $invoice->invoice_number = Invoice::max('invoice_number') + 1;
                $invoice->date = Carbon::now()->format('20y-m-d');
                $invoice->invoice_type = "transaction_invoice";
                $invoice->transaction_type = "online";
                $invoice->transaction_id = $t->id;
                $invoice->store_id = $t->store_id;
                $invoice->freeback_fee = $t->freeback_neto;
                $invoice->cashback_fee = $t->cashback_neto;
                $invoice->total = $invoice->freeback_fee + $invoice->cashback_fee;
                $invoice->save();
                $t->invoiced = 1;
                $t->invoice_id = $invoice->id;
                $t->save();
            }

            $toInvoiceOffline = Transaction::where('status','completed')->where('invoiced',0)->get();
            foreach($toInvoiceOffline as $t){
                $invoice = new Invoice();
                $invoice->invoice_number = Invoice::max('invoice_number') + 1;
                $invoice->date = Carbon::now()->format('20y-m-d');
                $invoice->invoice_type = "transaction_invoice";
                $invoice->transaction_type = "offline";
                $invoice->transaction_id = $t->id;
                $invoice->store_id = $t->store_id;
                $invoice->freeback_fee = $t->freeback_neto;
                $invoice->cashback_fee = $t->cashback_neto;
                $invoice->total = $invoice->freeback_fee + $invoice->cashback_fee;
                $invoice->save();
                $t->invoiced = 1;
                $t->invoice_id = $invoice->id;
                $t->save();
            }
        })->everyMinute();


      /*  $schedule->call(function(){
            $dropPayActive = DropPayConfiguration::where('valid',1)->get();
            foreach($dropPayActive as $dp) {
                $dp->valid = 0;
                $dp->save();
            }
        })->everyMinute();*/

        $schedule->call(function(){
            $stores = Store::where('active',1)->get();
            foreach($stores as $store){
                if(CashTransaction::where('store_id',$store->id)->where('invoiced',0)->where('status','accepted')->count() > 0){
                    $cashTransactions = CashTransaction::where('store_id',$store->id)->where('invoiced',0)->where('status','accepted')->get();
                    $totalSum = 0;
                    $freebackNeto = 0;
                    $cashBackNeto = 0;
                    foreach($cashTransactions as $transaction){
                        $totalSum += $transaction->freeback_neto + $transaction->cashback_neto;
                        $freebackNeto += $transaction->freeback_neto;
                        $cashBackNeto += $transaction->cashback_neto;
                    }
                    $invoice = CashInvoice::create([
                        'invoice_number' => CashInvoice::max('invoice_number') + 1,
                        'date' => Carbon::now()->format('20y-m-d'),
                        'store_id' => $store->id,
                        'total' => $totalSum,
                        'freeback_fee' => $freebackNeto,
                        'cashback_fee' => $cashBackNeto,
                        'valid' => 1,
                    ]);

                    foreach($cashTransactions as $transaction) {
                        $transaction->invoiced = 1;
                        $transaction->cash_invoice_id = $invoice->id;
                        $transaction->save();
                    }
                }
            }
        })->everyMinute();

        $schedule->call(function(){
            $plattformFees = FeesInfo::where('active',1)->first();
            $cashTransactions = CashTransaction::where('status','accepted')->where('royalty_check',0)->get();
            $offlineTransactions = Transaction::where('status','completed')->where('royalty_check',0)->get();
            $onlineTransactions = OnlineTransaction::where('status','completed')->where('royalty_check',0)->get();

            foreach($cashTransactions as $transaction){
                $user = User::where('id',$transaction->user_id)->first();
                $store = Store::where('id',$transaction->store_id)->first();
                $userReferralCode = $user->referral_code;
                $storeReferralCode = $store->referral_code;
                if(($userReferralCode != null) || ($userReferralCode != "")) {
                    if(preg_match("/[USP]-[0-9][0-9][0-9][0-9][0-9][0-9][0-9]/",$userReferralCode)){
                        switch ($userReferralCode[0]){
                            case "S":{
                                if(Store::where('own_referral_code',$userReferralCode)->count() == 1){
                                    $import =  round($plattformFees->royalty_fee/100 * $transaction->freeback_neto,2);
                                    if($import <= 0) { $import = 0.01; }
                                    StoreReferralTransaction::create([
                                        'store_id' => $transaction->store_id,
                                        'user_id' => $transaction->user_id,
                                        'transaction_type' => 'cash',
                                        'transaction_id' =>  $transaction->id,
                                        'status' => 'missing_payment',
                                        'import' => $import,
                                    ]);
                                    $transaction->royalty_check = 1;
                                    $transaction->save();
                                }
                                break;
                            }
                            case "U":{
                                break;
                            }
                            case "P":{
                                if(Getter::where('referral_code',$userReferralCode)->where('active',1)->count() == 1){
                                    $getter = Getter::where('referral_code',$userReferralCode)->where('active',1)->first();
                                    $import =  round($getter->fee_rate/100 * $transaction->freeback_neto,2);
                                    if($import <= 0) { $import = 0.01; }

                                    GetterTransaction::create([
                                        'getter_id' => $getter->id,
                                        'transaction_type' => 'cash',
                                        'event' => 'transaction',
                                        'transaction_id' => $transaction->id,
                                        'fb_fee_import' => $transaction->freeback_neto,
                                        'getter_fee_rate' => $getter->fee_rate,
                                        'import' => $import,
                                    ]);

                                    $transaction->royalty_check = 1;
                                    $transaction->save();

                                    $getter->fees_sum += $import;
                                    $getter->save();
                                }
                                break;
                            }
                        }
                    } else {
                        if(Getter::where('referral_code',$userReferralCode)->count() == 1){
                            $getter = Getter::where('referral_code',$userReferralCode)->where('active',1)->first();
                            $import =  round($getter->fee_rate/100 * $transaction->freeback_neto,2);
                            if($import <= 0) { $import = 0.01; }
                            GetterTransaction::create([
                                'getter_id' => $getter->id,
                                'transaction_type' => 'cash',
                                'event' => 'transaction',
                                'transaction_id' => $transaction->id,
                                'fb_fee_import' => $transaction->freeback_neto,
                                'getter_fee_rate' => $getter->fee_rate,
                                'import' => $import,
                            ]);

                            $transaction->royalty_check = 1;
                            $transaction->save();
                            $getter->fees_sum += $import;
                            $getter->save();
                        }
                    }
                }

                if($userReferralCode != $storeReferralCode){

                    if(($storeReferralCode != null) && ($storeReferralCode != "")) {
                        if(preg_match("/[USP]-[0-9][0-9][0-9][0-9][0-9][0-9][0-9]/",$userReferralCode)){
                            switch ($storeReferralCode[0]){
                                case "S":{
                                    if(Store::where('own_referral_code',$storeReferralCode)->count() == 1){
                                        $store = Store::where('own_referral_code',$storeReferralCode)->first();
                                        $import =  round($plattformFees->royalty_fee/100 * $transaction->freeback_neto,2);
                                        if($import <= 0) { $import = 0.01; }
                                        StoreReferralTransaction::create([
                                            'store_id' => $store->store_id,
                                            'user_id' => $transaction->user_id,
                                            'transaction_type' => 'cash',
                                            'transaction_id' =>  $transaction->id,
                                            'status' => 'missing_payment',
                                            'import' => $import,
                                        ]);
                                        $transaction->royalty_check = 1;
                                        $transaction->save();
                                    }
                                    break;
                                }
                                case "U":{
                                    break;
                                }
                                case "P":{
                                    if(Getter::where('referral_code',$storeReferralCode)->where('active',1)->count() == 1){
                                        $getter = Getter::where('referral_code',$storeReferralCode)->where('active',1)->first();
                                        $import =  round($getter->fee_rate/100 * $transaction->freeback_neto,2);
                                        GetterTransaction::create([
                                            'getter_id' => $getter->id,
                                            'transaction_type' => 'cash',
                                            'event' => 'transaction',
                                            'transaction_id' => $transaction->id,
                                            'fb_fee_import' => $transaction->freeback_neto,
                                            'getter_fee_rate' => $getter->fee_rate,
                                            'import' => $import,
                                        ]);
                                        $transaction->royalty_check = 1;
                                        $transaction->save();

                                        $getter->fees_sum += $import;
                                        $getter->save();
                                    }
                                    break;
                                }
                            }
                        }
                        else {
                            if(Getter::where('referral_code',$storeReferralCode)->count() == 1){
                                $getter = Getter::where('referral_code',$storeReferralCode)->where('active',1)->first();
                                $import =  round($getter->fee_rate/100 * $transaction->freeback_neto,2);
                                if($import <= 0) { $import = 0.01; }
                                GetterTransaction::create([
                                    'getter_id' => $getter->id,
                                    'transaction_type' => 'cash',
                                    'event' => 'transaction',
                                    'transaction_id' => $transaction->id,
                                    'fb_fee_import' => $transaction->freeback_neto,
                                    'getter_fee_rate' => $getter->fee_rate,
                                    'import' => $import,
                                ]);

                                $transaction->royalty_check = 1;
                                $transaction->save();

                                $getter->fees_sum += $import;
                                $getter->save();
                            }
                        }
                    }
                }
            }


            foreach($onlineTransactions as $transaction){
                $user = User::where('id',$transaction->user_id)->first();
                $store = Store::where('id',$transaction->store_id)->first();
                $userReferralCode = $user->referral_code;
                $storeReferralCode = $store->referral_code;
                if(($userReferralCode != null) || ($userReferralCode != "")) {
                    if(preg_match("/[USP]-[0-9][0-9][0-9][0-9][0-9][0-9][0-9]/",$userReferralCode)){
                        switch ($userReferralCode[0]){
                            case "S":{
                                if(Store::where('own_referral_code',$userReferralCode)->count() == 1){
                                    $import =  round($plattformFees->royalty_fee/100 * $transaction->freeback_neto,2);
                                    if($import <= 0) { $import = 0.01; }
                                    StoreReferralTransaction::create([
                                        'store_id' => $transaction->store_id,
                                        'user_id' => $transaction->user_id,
                                        'transaction_type' => 'online',
                                        'transaction_id' =>  $transaction->id,
                                        'status' => 'missing_payment',
                                        'import' => $import,
                                    ]);
                                    $transaction->royalty_check = 1;
                                    $transaction->save();
                                }
                                break;
                            }
                            case "U":{
                                break;
                            }
                            case "P":{
                                if(Getter::where('referral_code',$userReferralCode)->where('active',1)->count() == 1){
                                    $getter = Getter::where('referral_code',$userReferralCode)->where('active',1)->first();
                                    $import =  round($getter->fee_rate/100 * $transaction->freeback_neto,2);
                                    if($import <= 0) { $import = 0.01; }

                                    GetterTransaction::create([
                                        'getter_id' => $getter->id,
                                        'transaction_type' => 'online',
                                        'event' => 'transaction',
                                        'transaction_id' => $transaction->id,
                                        'fb_fee_import' => $transaction->freeback_neto,
                                        'getter_fee_rate' => $getter->fee_rate,
                                        'import' => $import,
                                    ]);

                                    $transaction->royalty_check = 1;
                                    $transaction->save();

                                    $getter->fees_sum += $import;
                                    $getter->save();
                                }
                                break;
                            }
                        }
                    } else {
                        if(Getter::where('referral_code',$userReferralCode)->count() == 1){
                            $getter = Getter::where('referral_code',$userReferralCode)->where('active',1)->first();
                            $import =  round($getter->fee_rate/100 * $transaction->freeback_neto,2);
                            if($import <= 0) { $import = 0.01; }
                            GetterTransaction::create([
                                'getter_id' => $getter->id,
                                'transaction_type' => 'online',
                                'event' => 'transaction',
                                'transaction_id' => $transaction->id,
                                'fb_fee_import' => $transaction->freeback_neto,
                                'getter_fee_rate' => $getter->fee_rate,
                                'import' => $import,
                            ]);

                            $transaction->royalty_check = 1;
                            $transaction->save();
                            $getter->fees_sum += $import;
                            $getter->save();
                        }
                    }
                }

                if($userReferralCode != $storeReferralCode){

                    if(($storeReferralCode != null) && ($storeReferralCode != "")) {
                        if(preg_match("/[USP]-[0-9][0-9][0-9][0-9][0-9][0-9][0-9]/",$userReferralCode)){
                            switch ($storeReferralCode[0]){
                                case "S":{
                                    if(Store::where('own_referral_code',$storeReferralCode)->count() == 1){
                                        $store = Store::where('own_referral_code',$storeReferralCode)->first();
                                        $import =  round($plattformFees->royalty_fee/100 * $transaction->freeback_neto,2);
                                        if($import <= 0) { $import = 0.01; }
                                        StoreReferralTransaction::create([
                                            'store_id' => $store->store_id,
                                            'user_id' => $transaction->user_id,
                                            'transaction_type' => 'online',
                                            'transaction_id' =>  $transaction->id,
                                            'status' => 'missing_payment',
                                            'import' => $import,
                                        ]);
                                        $transaction->royalty_check = 1;
                                        $transaction->save();
                                    }
                                    break;
                                }
                                case "U":{
                                    break;
                                }
                                case "P":{
                                    if(Getter::where('referral_code',$storeReferralCode)->where('active',1)->count() == 1){
                                        $getter = Getter::where('referral_code',$storeReferralCode)->where('active',1)->first();
                                        $import =  round($getter->fee_rate/100 * $transaction->freeback_neto,2);
                                        GetterTransaction::create([
                                            'getter_id' => $getter->id,
                                            'transaction_type' => 'online',
                                            'event' => 'transaction',
                                            'transaction_id' => $transaction->id,
                                            'fb_fee_import' => $transaction->freeback_neto,
                                            'getter_fee_rate' => $getter->fee_rate,
                                            'import' => $import,
                                        ]);
                                        $transaction->royalty_check = 1;
                                        $transaction->save();

                                        $getter->fees_sum += $import;
                                        $getter->save();
                                    }
                                    break;
                                }
                            }
                        }
                        else {
                            if(Getter::where('referral_code',$storeReferralCode)->count() == 1){
                                $getter = Getter::where('referral_code',$storeReferralCode)->where('active',1)->first();
                                $import =  round($getter->fee_rate/100 * $transaction->freeback_neto,2);
                                if($import <= 0) { $import = 0.01; }
                                GetterTransaction::create([
                                    'getter_id' => $getter->id,
                                    'transaction_type' => 'online',
                                    'event' => 'transaction',
                                    'transaction_id' => $transaction->id,
                                    'fb_fee_import' => $transaction->freeback_neto,
                                    'getter_fee_rate' => $getter->fee_rate,
                                    'import' => $import,
                                ]);

                                $transaction->royalty_check = 1;
                                $transaction->save();

                                $getter->fees_sum += $import;
                                $getter->save();
                            }
                        }
                    }
                }
            }

            foreach($offlineTransactions as $transaction){
                $user = User::where('id',$transaction->user_id)->first();
                $store = Store::where('id',$transaction->store_id)->first();
                $userReferralCode = $user->referral_code;
                $storeReferralCode = $store->referral_code;
                if(($userReferralCode != null) || ($userReferralCode != "")) {
                    if(preg_match("/[USP]-[0-9][0-9][0-9][0-9][0-9][0-9][0-9]/",$userReferralCode)){
                        switch ($userReferralCode[0]){
                            case "S":{
                                if(Store::where('own_referral_code',$userReferralCode)->count() == 1){
                                    $import =  round($plattformFees->royalty_fee/100 * $transaction->freeback_neto,2);
                                    if($import <= 0) { $import = 0.01; }
                                    StoreReferralTransaction::create([
                                        'store_id' => $transaction->store_id,
                                        'user_id' => $transaction->user_id,
                                        'transaction_type' => 'offline',
                                        'transaction_id' =>  $transaction->id,
                                        'status' => 'missing_payment',
                                        'import' => $import,
                                    ]);
                                    $transaction->royalty_check = 1;
                                    $transaction->save();
                                }
                                break;
                            }
                            case "U":{
                                break;
                            }
                            case "P":{
                                if(Getter::where('referral_code',$userReferralCode)->where('active',1)->count() == 1){
                                    $getter = Getter::where('referral_code',$userReferralCode)->where('active',1)->first();
                                    $import =  round($getter->fee_rate/100 * $transaction->freeback_neto,2);
                                    if($import <= 0) { $import = 0.01; }

                                    GetterTransaction::create([
                                        'getter_id' => $getter->id,
                                        'transaction_type' => 'offline',
                                        'event' => 'transaction',
                                        'transaction_id' => $transaction->id,
                                        'fb_fee_import' => $transaction->freeback_neto,
                                        'getter_fee_rate' => $getter->fee_rate,
                                        'import' => $import,
                                    ]);

                                    $transaction->royalty_check = 1;
                                    $transaction->save();

                                    $getter->fees_sum += $import;
                                    $getter->save();
                                }
                                break;
                            }
                        }
                    } else {
                        if(Getter::where('referral_code',$userReferralCode)->count() == 1){
                            $getter = Getter::where('referral_code',$userReferralCode)->where('active',1)->first();
                            $import =  round($getter->fee_rate/100 * $transaction->freeback_neto,2);
                            if($import <= 0) { $import = 0.01; }
                            GetterTransaction::create([
                                'getter_id' => $getter->id,
                                'transaction_type' => 'offline',
                                'event' => 'transaction',
                                'transaction_id' => $transaction->id,
                                'fb_fee_import' => $transaction->freeback_neto,
                                'getter_fee_rate' => $getter->fee_rate,
                                'import' => $import,
                            ]);

                            $transaction->royalty_check = 1;
                            $transaction->save();
                            $getter->fees_sum += $import;
                            $getter->save();
                        }
                    }
                }

                if($userReferralCode != $storeReferralCode){

                    if(($storeReferralCode != null) && ($storeReferralCode != "")) {
                        if(preg_match("/[USP]-[0-9][0-9][0-9][0-9][0-9][0-9][0-9]/",$userReferralCode)){
                            switch ($storeReferralCode[0]){
                                case "S":{
                                    if(Store::where('own_referral_code',$storeReferralCode)->count() == 1){
                                        $store = Store::where('own_referral_code',$storeReferralCode)->first();
                                        $import =  round($plattformFees->royalty_fee/100 * $transaction->freeback_neto,2);
                                        if($import <= 0) { $import = 0.01; }
                                        StoreReferralTransaction::create([
                                            'store_id' => $store->store_id,
                                            'user_id' => $transaction->user_id,
                                            'transaction_type' => 'offline',
                                            'transaction_id' =>  $transaction->id,
                                            'status' => 'missing_payment',
                                            'import' => $import,
                                        ]);
                                        $transaction->royalty_check = 1;
                                        $transaction->save();
                                    }
                                    break;
                                }
                                case "U":{
                                    break;
                                }
                                case "P":{
                                    if(Getter::where('referral_code',$storeReferralCode)->where('active',1)->count() == 1){
                                        $getter = Getter::where('referral_code',$storeReferralCode)->where('active',1)->first();
                                        $import =  round($getter->fee_rate/100 * $transaction->freeback_neto,2);
                                        GetterTransaction::create([
                                            'getter_id' => $getter->id,
                                            'transaction_type' => 'offline',
                                            'event' => 'offline',
                                            'transaction_id' => $transaction->id,
                                            'fb_fee_import' => $transaction->freeback_neto,
                                            'getter_fee_rate' => $getter->fee_rate,
                                            'import' => $import,
                                        ]);
                                        $transaction->royalty_check = 1;
                                        $transaction->save();

                                        $getter->fees_sum += $import;
                                        $getter->save();
                                    }
                                    break;
                                }
                            }
                        }
                        else {
                            if(Getter::where('referral_code',$storeReferralCode)->count() == 1){
                                $getter = Getter::where('referral_code',$storeReferralCode)->where('active',1)->first();
                                $import =  round($getter->fee_rate/100 * $transaction->freeback_neto,2);
                                if($import <= 0) { $import = 0.01; }
                                GetterTransaction::create([
                                    'getter_id' => $getter->id,
                                    'transaction_type' => 'offline',
                                    'event' => 'transaction',
                                    'transaction_id' => $transaction->id,
                                    'fb_fee_import' => $transaction->freeback_neto,
                                    'getter_fee_rate' => $getter->fee_rate,
                                    'import' => $import,
                                ]);

                                $transaction->royalty_check = 1;
                                $transaction->save();

                                $getter->fees_sum += $import;
                                $getter->save();
                            }
                        }
                    }
                }
            }

        });


    }


    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}

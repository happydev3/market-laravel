<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class StoreOrderNotify extends Mailable
{
    use Queueable, SerializesModels;

    public $business_name;
    public $product;
    public $qta;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($business_name,$product,$qta)
    {
        $this->business_name = $business_name;
        $this->product = $product;
        $this->qta = $qta;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.store_order_notify');
    }
}

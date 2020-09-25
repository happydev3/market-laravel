<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class OrderDispute extends Mailable
{
    use Queueable, SerializesModels;

    public $dispute;
    public $order;
    public $store;
    public $user;
    public $product;

    public function __construct($dispute,$order, $store, $user,$product)
    {
        $this->dispute = $dispute;
        $this->order = $order;
        $this->store = $store;
        $this->user = $user;
        $this->product = $product;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.order_dispute');
    }
}

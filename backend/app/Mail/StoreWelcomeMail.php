<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class StoreWelcomeMail extends Mailable
{
    use Queueable, SerializesModels;

    public $business_name;
    public $store_token;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($bn,$token)
    {
        $this->business_name = $bn;
        $this->store_token = $token;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.store_welcome');
    }
}

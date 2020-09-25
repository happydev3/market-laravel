<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserOrderDoneMail extends Mailable
{
    use Queueable, SerializesModels;
    public $name_surname;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name_surname)
    {
        $this->name_surname = $name_surname;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.user_order_completed');
    }
}

<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class StoreDocumentsReminder extends Mailable
{
    use Queueable, SerializesModels;
    public $business_name;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($business_name)
    {
        $this->business_name = $business_name;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.store_documents_reminder');
    }
}

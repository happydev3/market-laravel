<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class HelpRequestResponse extends Mailable
{
    use Queueable, SerializesModels;


    public $name;
    public $request;
    public $answer;

    public function __construct($name, $request,$answer)
    {
        $this->name = $name;
        $this->request = $request;
        $this->answer = $answer;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.help_request_response');
    }
}

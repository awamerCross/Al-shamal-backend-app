<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendMail extends Mailable
{
    use Queueable, SerializesModels;

    public $message;

    public function __construct($message)
    {
        $this->message = $message;
    }


    public function build(): SendMail
    {
        $msg = $this->message;

        return $this->subject('Test mail from aait')->view('emails.send_mail',compact('msg'));
    }
}

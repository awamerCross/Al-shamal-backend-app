<?php

namespace App\Jobs;

use App\Mail\SendMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class EmailAll implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $emails, $message;

    public function __construct($emails, $message)
    {
        $this->emails = $emails;
        $this->message = $message;
    }


    public function handle(): void
    {

        foreach ($this->emails as $email) {
            Mail::to($email)->send(new SendMail($this->message));
        }

    }
}

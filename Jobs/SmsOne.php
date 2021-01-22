<?php

namespace App\Jobs;

use App\Libraries\Sms;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SmsOne implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $phone, $message;


    public function __construct($phone, $message)
    {
        $this->phone = $phone;
        $this->message = $message;
    }


    public function handle(): void
    {
        Sms::send_sms_yamamah($this->phone, $this->message);
    }
}

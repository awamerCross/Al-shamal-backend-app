<?php

namespace App\Jobs;

use App\Libraries\Sms;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SmsAll implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $phone, $message , $key;


    public function __construct($phone, $key,$message)
    {
        $this->phone = $phone;
        $this->key = $key;
        $this->message = $message;

    }


    public function handle(): void
    {

        Sms::send_sms_yamamah($this->phone,$this->key , $this->message);
    }
}

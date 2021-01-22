<?php

namespace App\Jobs;

use App\Notifications\Admin\AdminNotify;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class NotifyOne implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user, $data;


    public function __construct($user, $data)
    {
        $this->user = $user;
        $this->data = $data;
    }


    public function handle(): void
    {
        $tokens = $this->user->devices->pluck('device_id')->toArray();
        $this->user->notify(new AdminNotify($tokens, $this->data));
    }
}

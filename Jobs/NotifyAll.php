<?php

namespace App\Jobs;

use App\Notifications\Admin\AdminNotify;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class NotifyAll implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $users, $data;

    public function __construct($users, $data)
    {
        $this->users = $users;
        $this->data = $data;
    }


    public function handle(): void
    {

        foreach ($this->users as $user) {

            $tokens = $user->devices->pluck('device_id')->toArray();
            $user->notify(new AdminNotify($tokens, $this->data));

        }
    }
}

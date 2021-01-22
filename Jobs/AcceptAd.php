<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Notifications\AcceptAdNotification;
use App\Traits\Expo;

class AcceptAd implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    use Expo;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $user, $data;


    public function __construct($user, $data)
    {
        $this->user = $user;
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->sendExpoNotify($this->user , $this->data) ;
        $this->user->notify(new AcceptAdNotification($this->data));
    }
}

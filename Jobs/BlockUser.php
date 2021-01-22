<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Traits\Expo;

class BlockUser implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels , Expo;

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
    }
}

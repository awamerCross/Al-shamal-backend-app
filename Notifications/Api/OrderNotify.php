<?php

namespace App\Notifications\Api;

use App\Libraries\Firebase;
use App\Services\NotificationService;
use Illuminate\Bus\Queueable;

use Illuminate\Notifications\Notification;

class OrderNotify extends Notification
{
    use Queueable;

    protected $tokens, $data , $fcm;

    public function __construct($tokens, $data)
    {
        $this->tokens = $tokens;
        $this->data   = $data;
     }


    public function via($notifiable)
    {
        return ['database'];
    }


    public function toDatabase($notifiable)
    {
        (new Firebase)->sendNotify($this->tokens, NotificationService::setOrderFcm($this->data));
        return NotificationService::setOrderNotification($this->data);
    }


}

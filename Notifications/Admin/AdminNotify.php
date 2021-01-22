<?php

namespace App\Notifications\Admin;

use App\Libraries\Firebase;
use App\Services\NotificationService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AdminNotify extends Notification
{
    use Queueable;

    protected $tokens, $data;

    public function __construct($tokens, $data)
    {
        $this->tokens = $tokens;
        $this->data = $data;
    }


    public function via($notifiable)
    {
        return ['database'];
    }


    public function toDatabase($notifiable)
    {
        (new Firebase)->sendNotify($this->tokens, NotificationService::setFcm($this->data));
        return NotificationService::setAdminNotification($this->data);
    }


}

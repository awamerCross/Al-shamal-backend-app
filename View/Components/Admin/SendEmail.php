<?php

namespace App\View\Components\Admin;

use Illuminate\View\Component;

class SendEmail extends Component
{
    public $email;

    public function __construct($email)
    {
        $this->email = $email;
    }


    public function render()
    {
        return view('components.admin.send-email');
    }
}

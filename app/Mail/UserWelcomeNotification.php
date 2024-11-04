<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

use Illuminate\Support\Facades\Config;

class UserWelcomeNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $founder_name;

    public function __construct($founder_name)
    {
        $this->founder_name = $founder_name;
    }

    public function build()
    {
        $appName = config('app.name'); // Fetch the app name from configuration

        return $this->subject('Welcome to ' . $appName)
                    ->view('emails.registration.user_welcome_notification');
    }
}

<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewUserRegistrationForAdmin extends Mailable
{
    use Queueable, SerializesModels;

    public $founder_name;
    public $email;

    public function __construct($founder_name, $email)
    {
        $this->founder_name = $founder_name;
        $this->email = $email;
    }

    public function build()
    {
        return $this->subject('New User Registration Request')
                    ->view('emails.registration/new_user_registration_admin');
    }
}

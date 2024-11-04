<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ResetPasswordEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $newPassword;

    public function __construct($user, string $newPassword)
    {
        $this->user = $user; // Pass the user object directly
        $this->newPassword = $newPassword; // Pass the new password
    }

    public function build()
    {
        return $this->view('emails.reset_password') // Use a specific view for the email
                    ->subject('Password Reset Request')
                    ->with([
                        'user' => $this->user,
                        'newPassword' => $this->newPassword,
                    ]);
    }
}

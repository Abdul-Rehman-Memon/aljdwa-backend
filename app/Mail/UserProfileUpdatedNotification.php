<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserProfileUpdatedNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $user; // The user object with updated profile data

    /**
     * Create a new message instance.
     *
     * @param $user
     */
    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('User Profile Updated Notification')
                    ->view('emails.user.user_profile_updated_notification');
    }
}

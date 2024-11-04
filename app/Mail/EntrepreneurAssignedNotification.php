<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EntrepreneurAssignedNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $entrepreneurName;
    public $mentorName;

    /**
     * Create a new message instance.
     *
     * @param string $entrepreneurName
     * @param string $mentorName
     */
    public function __construct($entrepreneurName, $mentorName)
    {
        $this->entrepreneurName = $entrepreneurName;
        $this->mentorName = $mentorName;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        $subject = "You Have Been Assigned a Mentor";
        return $this->subject($subject)
                    ->view('emails.entrepreneur.entrepreneur_assigned_notification');
    }
}

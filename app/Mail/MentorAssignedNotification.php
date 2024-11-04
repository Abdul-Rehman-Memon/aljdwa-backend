<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MentorAssignedNotification extends Mailable
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
        $subject = "Mentor Assignment Notification";
        return $this->subject($subject)
                    ->view('emails.mentor.mentor_assigned_notification');
    }
}

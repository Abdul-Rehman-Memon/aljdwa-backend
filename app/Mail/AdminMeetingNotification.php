<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AdminMeetingNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $senderName;
    public $receiverName;
    public $senderRole;  // New property for sender's role
    public $receiverRole; // New property for receiver's role
    public $link;
    public $meetingPassword;
    public $agenda;
    public $meetingDateTime;
    public $status;

    /**
     * Create a new message instance.
     *
     * @param string $senderName
     * @param string $receiverName
     * @param string $senderRole
     * @param string $receiverRole
     * @param string $link
     * @param string $meetingPassword
     * @param string $agenda
     * @param string $meetingDateTime
     * @param string $status
     */
    public function __construct($senderName, $receiverName, $senderRole, $receiverRole, $link, $meetingPassword, $agenda, $meetingDateTime, $status)
    {
        $this->senderName = $senderName;
        $this->receiverName = $receiverName;
        $this->senderRole = $senderRole;  // Set sender's role
        $this->receiverRole = $receiverRole; // Set receiver's role
        $this->link = $link;
        $this->meetingPassword = $meetingPassword;
        $this->agenda = $agenda;
        $this->meetingDateTime = $meetingDateTime;
        $this->status = $status;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        $subject = "Admin Notification: Meeting Scheduled Between {$this->senderName} and {$this->receiverName}";
        return $this->subject($subject)
                    ->view('emails.meeting.admin_meeting_notification'); // Create a corresponding Blade view
    }
}

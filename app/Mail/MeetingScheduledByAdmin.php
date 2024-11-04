<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MeetingScheduledByAdmin extends Mailable
{
    use Queueable, SerializesModels;

    public $senderName;
    public $receiverName;
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
     * @param string $link
     * @param string $meetingPassword
     * @param string $agenda
     * @param string $meetingDateTime
     * @param string $status
     */
    public function __construct($senderName, $receiverName, $link, $meetingPassword, $agenda, $meetingDateTime, $status)
    {
        $this->senderName = $senderName;
        $this->receiverName = $receiverName;
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
        $subject = "Meeting Notification - Status: {$this->status}";
        return $this->subject($subject)
                    ->view('emails.meeting.meeting_scheduled_by_admin');
    }
}

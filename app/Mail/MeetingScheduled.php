<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class MeetingScheduled extends Mailable
{
    use Queueable, SerializesModels;

    public $name;
    public $meetingStatus;
    public $meetingLink;
    public $meetingPassword;

    public function __construct($name, $meetingStatus, $meetingLink, $meetingPassword)
    {
        $this->name = $name;
        $this->meetingStatus = $meetingStatus;
        $this->meetingLink = $meetingLink;
        $this->meetingPassword = $meetingPassword;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: config('app.name').' - Meeting Notification',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.meeting',
            with: [
                'name' => $this->name,
                'meetingStatus' => $this->meetingStatus,
                'meetingLink' => $this->meetingLink,
                'meetingPassword' => $this->meetingPassword,
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}

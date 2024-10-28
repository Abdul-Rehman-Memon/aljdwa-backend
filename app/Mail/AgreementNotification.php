<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Attachment;

class AgreementNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $name;
    public $agreementDetails;
    public $status;
    public $attachmentPath;

    /**
     * Create a new message instance.
     */
    public function __construct($name, $agreementDetails, $status = null, $attachmentPath = null)
    {
        $this->name = $name;
        $this->agreementDetails = $agreementDetails;
        $this->status = $status;
        $this->attachmentPath = $attachmentPath;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: config('app.name').' - Agreement Notification',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.agreement',
            with: [
                'name' => $this->name,
                'agreementDetails' => $this->agreementDetails,
                'status' => $this->status,
            ],
        );
    }

    /**
     * Attach the agreement document if provided.
     *
     * @return array<int, Attachment>
     */
    public function attachments(): array
    {
        $attachments = [];

        if ($this->attachmentPath) {
            $attachments[] = new Attachment($this->attachmentPath);
        }

        return $attachments;
    }
}

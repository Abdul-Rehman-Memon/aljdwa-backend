<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class UserStatusNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $founder_name;
    public $status;
    public $status_message;

    public function __construct($founder_name, $status)
    {
        $this->founder_name = $founder_name;
        $this->status = $status;

        // Set the status message based on the status
        $this->status_message = $this->getStatusMessage($status);
    }

    public function build()
    {
        $appName = config('app.name');

        return $this->subject('Your Registration Status Update')
                    ->view('emails.registration.status_update')
                    ->with([
                        'founder_name' => $this->founder_name,
                        'status' => $this->status,
                        'status_message' => $this->status_message,
                    ]);
    }

    private function getStatusMessage($status)
    {
        switch ($status) {
            case 'approved':
                return 'Congratulations! Your registration has been approved. Welcome to ' . config('app.name') . '!';
            case 'rejected':
                return 'We\'re sorry to inform you that your registration has been rejected. If you have any questions, please contact support.';
            case 'returned':
                return 'Your registration request has been returned for further information. Please review your application and resubmit.';
            default:
                return 'Your registration status has been updated.';
        }
    }
}


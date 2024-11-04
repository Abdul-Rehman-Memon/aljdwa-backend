<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AgreementResponseNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $userName;
    public $agreementDetails;
    public $responseStatus; // 'accepted' or 'rejected'

    /**
     * Create a new message instance.
     *
     * @param string $userName
     * @param string $agreementDetails
     * @param string $responseStatus
     */
    public function __construct($userName, $agreementDetails, $responseStatus)
    {
        $this->userName = $userName;
        $this->agreementDetails = $agreementDetails;
        $this->responseStatus = $responseStatus;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $statusText = ucfirst($this->responseStatus); // Capitalize 'Accepted' or 'Rejected'
        return $this->subject("Agreement {$statusText} by {$this->userName}")
                    ->view('emails.agreement.agreement_response_notification');
    }
}

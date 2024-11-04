<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AgreementNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $userName;
    public $agreementDetails;
    public $agreementDocumentPath;

    /**
     * Create a new message instance.
     *
     * @param string $userName
     * @param string $agreementDetails
     * @param string|null $agreementDocumentPath
     */
    public function __construct($userName, $agreementDetails, $agreementDocumentPath = null)
    {
        $this->userName = $userName;
        $this->agreementDetails = $agreementDetails;
        $this->agreementDocumentPath = $agreementDocumentPath;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $email = $this->subject('New Agreement Created')
                      ->view('emails.agreement.agreement_notification');

        // Attach the agreement document if the path is provided
        if ($this->agreementDocumentPath) {
            // $email->attach(storage_path("app/{$this->agreementDocumentPath}"));
            // $email->attach($this->agreementDocumentPath);
            // $email->attach('http://localhost:8000/storage/public/9d5ce373-bf60-433e-8795-a1fe6533bb64/agreement/file-sample_150kB.pdf');
        }

        return $email;
    }
}

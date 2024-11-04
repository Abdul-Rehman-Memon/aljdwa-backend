<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PaymentConfirmationForUser extends Mailable
{
    use Queueable, SerializesModels;

    public $userName;
    public $amount;
    public $paymentDate;

    public function __construct($userName, $amount, $paymentDate)
    {
        $this->userName = $userName;
        $this->amount = $amount;
        $this->paymentDate = $paymentDate;
    }

    public function build()
    {
        return $this->subject('Payment Confirmation')
                    ->view('emails.payments.payment_confirmation_user');
    }
}

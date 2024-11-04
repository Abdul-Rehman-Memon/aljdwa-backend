<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AppointmentStatusNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $appointment;

    public function __construct($appointment)
    {
        $this->appointment = $appointment;
    }

    public function build()
    {
        $subject = $this->appointment['status'] === 'booked' 
            ? 'Your Appointment is Booked' 
            : 'Your Appointment Request has been Cancelled';

        return $this->subject($subject)
                    ->view('emails.appointments/appointment_status_notification');
    }
}

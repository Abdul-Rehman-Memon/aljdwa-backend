<?php

namespace App\Repositories\v1\Payments;

use App\Models\Payment;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Mail;
use App\Mail\PaymentConfirmationForUser;
use App\Mail\PaymentNotificationForAdmin;

class PaymentsRepository implements PaymentsInterface
{
    public function createPayment(array $data)
    {
        $data['entrepreneur_id'] = Auth::user()->id;
        $data['payment_date'] = Carbon::now()->toDateTimeString();
        $payment =  Payment::create($data);

        // Load payment status for returning full data
        $payment = $payment->load('payment_status');

        // Get user and admin emails
        $userEmail = Auth::user()->email;
        $userName = Auth::user()->founder_name;
        $amount = $payment['amount'];

        // Format payment_date to a more readable date-time format
        $paymentDate = Carbon::parse($payment['payment_date'])->format('d M Y, h:i A');

        $adminEmail = config('mail.admin_email'); // Ensure this is set in the .env
        // Send email to user
        // Mail::to($userEmail)->send(new PaymentConfirmationForUser($userName, $amount, $paymentDate));
        // Send email to admin
        // Mail::to($adminEmail)->send(new PaymentNotificationForAdmin($userName, $amount, $paymentDate));

        return $payment;
    }
}

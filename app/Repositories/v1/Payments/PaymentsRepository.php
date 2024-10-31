<?php

namespace App\Repositories\v1\Payments;

use App\Models\Payment;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;


class PaymentsRepository implements PaymentsInterface
{
    public function createPayment(array $data)
    {
        $data['entrepreneur_id'] = Auth::user()->id;
        $data['payment_date'] = Carbon::now()->toDateTimeString();
        $payment =  Payment::create($data);

        return $payment->load('payment_status');
    }
}

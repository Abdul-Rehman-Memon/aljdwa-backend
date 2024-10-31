<?php

namespace App\Repositories\v1\Payments;

interface PaymentsInterface
{
    public function createPayment(array $data);
}

<?php

namespace App\Repositories\v1\Payments;

interface PaymentsInterface
{
    public function createPayment(array $data);
    public function getEntrepreneurPayment();
    public function getAllPayments(object $data = null);
    public function getPayment(int $paymentId);
    public function updatePayment(array $data, int $paymentId);
    
}

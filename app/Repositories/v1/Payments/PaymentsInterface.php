<?php

namespace App\Repositories\v1\Payments;

interface PaymentsInterface
{
    public function createPaymentInvoice(array $data);
    public function getPaymentInvoice(string $id);
    public function createPayment(array $data);
    public function createCheckout(array $data);
    public function stripePaymentgateWay(array $data);
    public function verifyStripePayment(string $paymentIntentId);
    public function getEntrepreneurPayment();
    public function getAllPayments(object $data = null);
    public function getPayment(int $paymentId);
    public function updatePayment(array $data, int $paymentId);
    
}

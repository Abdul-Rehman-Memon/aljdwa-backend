<?php
namespace App\Services\v1;

use App\Repositories\v1\Payments\PaymentsInterface;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
class PaymentsService
{
    protected $paymentsRepository;

    public function __construct(PaymentsInterface $paymentsRepository)
    {
        $this->paymentsRepository = $paymentsRepository;
    }

    public function createPayment(array $data)
    {
        $payment = $this->paymentsRepository->createPayment($data);

        return $payment;
    }

    public function getEntrepreneurPayment()
    {
        $payment = $this->paymentsRepository->getEntrepreneurPayment();

        return $payment;
    }

    /***********Admin Section - Payments ***********/
    public function getAllPayments($data)
    {
        $payment = $this->paymentsRepository->getAllPayments($data);

        return $payment; 
    }

    public function getPayment($id)
    {
        $payment = $this->paymentsRepository->getPayment($id);

        return $payment; 
    }

    public function updatePayment($data, $id)
    {
        $payment = $this->paymentsRepository->updatePayment($data, $id);

        return $payment; 
    }
}

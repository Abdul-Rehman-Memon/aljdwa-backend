<?php

namespace App\Repositories\v1\Entrepreneur_agreement;

interface EntrepreneurAgreementInterface
{
    public function createEntrepreneurAgreement(array $data);
    public function getEntrepreneurAgreementWithPayment(string $entrepreneurDetailsId);
    public function getEntrepreneurAgreement();
    public function updateEntrepreneurAgreement(array $data);
    public function getAllAgreements(object $data = null);
    public function getAgreement(int $agreementId);
}

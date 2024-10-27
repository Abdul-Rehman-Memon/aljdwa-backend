<?php
namespace App\Services\v1;

use App\Repositories\v1\Entrepreneur_agreement\EntrepreneurAgreementInterface;

class EntreprenuerAgreementService
{
    protected $entreprenuerAgreementRepository;

    public function __construct(EntrepreneurAgreementInterface $entreprenuerAgreementRepository)
    {
        $this->entreprenuerAgreementRepository = $entreprenuerAgreementRepository;
    }

    
    public function createAgreement(array $data)
    {
        $agreement = $this->entreprenuerAgreementRepository->createEntrepreneurAgreement($data);

        return $agreement;
    }

    public function getEntrepreneurAgreementWithPayment(string $entrepreneurDetailsId)
    {
        $agreement = $this->entreprenuerAgreementRepository->getEntrepreneurAgreementWithPayment($entrepreneurDetailsId);

        return $agreement;
    }
}

<?php
namespace App\Services\v1;

use App\Repositories\v1\Entrepreneur_details\EntrepreneurDetailsInterface;

class EntreprenuerDetailsService
{
    protected $entreprenuerDetailsRepository;

    public function __construct(EntrepreneurDetailsInterface $entreprenuerDetailsRepository)
    {
        $this->entreprenuerDetailsRepository = $entreprenuerDetailsRepository;
    }

    public function getEntrepreneurApplications($limit, $offset)
    {
        $applications = $this->entreprenuerDetailsRepository->getEntrepreneurApplications($limit, $offset);

        return $applications;
    }

    public function reviewEntrepreneurApplication($applicationId)
    {
        $application = $this->entreprenuerDetailsRepository->reviewEntrepreneurApplication($applicationId);

        return $application;
    }

    public function updateEntrepreneurApplication($data, $appointmentId)
    {
        $application = $this->entreprenuerDetailsRepository->updateEntrepreneurApplication($data, $appointmentId);

        return $application;
    }
}

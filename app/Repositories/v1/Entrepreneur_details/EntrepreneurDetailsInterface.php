<?php

namespace App\Repositories\v1\Entrepreneur_details;

interface EntrepreneurDetailsInterface
{
    public function createEntrepreneurDetails(array $data);
    public function createCoFounders(array $data);
    public function updateCoFounders(array $data,string $userId);
    public function getEntrepreneurApplications(object $data);
    public function reviewEntrepreneurApplication(string $applicationId = null );
    public function updateEntrepreneurApplication(array $data, string $applicationId);
}

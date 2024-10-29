<?php

namespace App\Repositories\v1\Entrepreneur_details;

interface EntrepreneurDetailsInterface
{
    public function createEntrepreneurDetails(array $data);
    public function getEntrepreneurApplications($limit, $offset);
    public function reviewEntrepreneurApplication(string $applicationId = null );
    public function updateEntrepreneurApplicationStatusByAdmin(array $data, string $applicationId);
    public function uploadEntrepreneurDetailsFile(array $data);
    public function updateEntrepreneurApplication(array $data, string $applicationId);
}

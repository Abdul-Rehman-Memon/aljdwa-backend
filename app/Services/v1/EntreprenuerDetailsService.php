<?php
namespace App\Services\v1;

use App\Repositories\v1\Entreprenuer_details\EntreprenuerDetailsInterface;

class EntreprenuerDetailsService
{
    protected $startupDetailsRepository;

    public function __construct(EntreprenuerDetailsInterface $startupDetailsRepository)
    {
        $this->startupDetailsRepository = $startupDetailsRepository;
    }
}

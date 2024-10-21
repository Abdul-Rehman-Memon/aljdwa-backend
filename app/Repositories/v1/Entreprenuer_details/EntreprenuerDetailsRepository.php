<?php

namespace App\Repositories\v1\Entreprenuer_details;

use App\Models\EntreprenuerDetail;

class EntreprenuerDetailsRepository implements EntreprenuerDetailsInterface
{
    public function createEntreprenuerDetails(array $data)
    {
        return EntreprenuerDetail::create($data);
    }
}

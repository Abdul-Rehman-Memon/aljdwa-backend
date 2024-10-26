<?php

namespace App\Repositories\v1\Entrepreneur_agreement;

use App\Models\EntrepreneurAgreement;
use Illuminate\Support\Facades\Auth;

class EntrepreneurAgreementRepository implements EntrepreneurAgreementInterface
{
    public function createEntrepreneurAgreement(array $data)
    {
        $data['admin_id'] = Auth::user()->id;
        return EntrepreneurAgreement::create($data);
    }
}

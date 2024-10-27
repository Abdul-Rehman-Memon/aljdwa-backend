<?php

namespace App\Repositories\v1\Entrepreneur_agreement;

use App\Models\EntrepreneurAgreement;
use App\Models\EntrepreneurDetail;
use App\Models\Payment;

use Illuminate\Support\Facades\Auth;

class EntrepreneurAgreementRepository implements EntrepreneurAgreementInterface
{
    public function createEntrepreneurAgreement(array $data)
    {
        $data['admin_id'] = Auth::user()->id;
        return EntrepreneurAgreement::create($data);
    }

    public function getEntrepreneurAgreementWithPayment(string $entrepreneurDetailsId)
    {
        $result = EntrepreneurAgreement::with(
            ['agreement_entrepreneur_detail', //entrepreneur_agreement -> entrepreneur_details
             'agreement_status', ////entrepreneur_agreement -> lookup_details
             'agreement_entrepreneur_detail.entrepreneur_details_payment',//entrepreneur_agreement -> entrepreneur_details -> payment
             'agreement_entrepreneur_detail.entrepreneur_details_payment.payment_status', ////entrepreneur_agreement -> entrepreneur_details -> payment -> lookup_details
            ])
            ->where('entrepreneur_details_id',$entrepreneurDetailsId)->first();

            if($result){
                return  [
                    'agreement_status' => $result->agreement_status->value,
                    'payment_status' => $result->agreement_entrepreneur_detail->entrepreneur_details_payment->payment_status->value,
                ];
            }

            return  [
                'agreement_status' => null,
                'payment_status' => null,
            ];

            
    }
}

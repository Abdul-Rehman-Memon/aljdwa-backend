<?php

namespace App\Repositories\v1\Entrepreneur_agreement;

use App\Models\EntrepreneurAgreement;
use App\Models\EntrepreneurDetail;
use App\Models\Payment;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class EntrepreneurAgreementRepository implements EntrepreneurAgreementInterface
{
    public function createEntrepreneurAgreement(array $data)
    {
        $file = $data['agreement_document'];
        $userId  = Auth::user()->id;
        $data['admin_id'] = $userId;

        // Define the directory path: user_id/agreement/
        $directory = "public/{$userId}/agreement";

        // Check if directory exists, create it if it doesn’t
        if (!File::exists(storage_path("app/{$directory}"))) {
            File::makeDirectory(storage_path("app/{$directory}"), 0755, true);
        }
        // Store the file with the original filename in the specified directory
        // $filePath = $file->storeAs($directory, $file->getClientOriginalName());
        $filePath = Storage::disk('public')->putFileAs($directory, $file, $file->getClientOriginalName());
        $data['agreement_document'] = $filePath;
        return EntrepreneurAgreement::create($data);
    }

    public function getEntrepreneurAgreementWithPayment(string $entrepreneurDetailsId)
    {
        return EntrepreneurAgreement::with([
            'agreement_entrepreneur_detail',  // Fetches entrepreneur details for the agreement
            'agreement_status',               // Fetches agreement status (e.g., lookup details)
            'agreement_entrepreneur_detail.entrepreneur_details_payment', // Fetches payments related to entrepreneur details
            'agreement_entrepreneur_detail.entrepreneur_details_payment.payment_status', // Fetches status of each payment
        ])
        ->whereHas('agreement_entrepreneur_detail', function ($query) use ($entrepreneurDetailsId) {
            $query->where('entrepreneur_details_id', $entrepreneurDetailsId);
        })
        ->whereHas('agreement_entrepreneur_detail.entrepreneur_details_payment', function ($query) use ($entrepreneurDetailsId) {
            $query->where('entrepreneur_details_id', $entrepreneurDetailsId);
        })
        ->first();         
    }

    public function getEntrepreneurAgreement()
    {
        $userId = Auth::user()->id;
        $result = EntrepreneurAgreement::with(
            ['agreement_status', ////entrepreneur_agreement -> lookup_details,
             'agreement_entrepreneur_detail' => function ($query) use ($userId){
                $query->where('entrepreneur_details.user_id',$userId); 
                },
            ])
            ->first();

            if($result){
                return  $result;
            }
            return false;
            
    }

    public function updateEntrepreneurAgreement(array $data, int $agreementId)
    {
        $data['signed_At'] = Carbon::now()->toDateTimeString();
        $agreement = EntrepreneurAgreement::with(['agreement_status', ////entrepreneur_agreement -> lookup_details,
             'agreement_entrepreneur_detail'
            ])->find($agreementId);
        
        if ($agreement && $agreement->update($data)) {
            return $agreement->fresh(
                ['agreement_status', ////entrepreneur_agreement -> lookup_details,
                'agreement_entrepreneur_detail'
               ]);
        }
          
        return false;
    }
}
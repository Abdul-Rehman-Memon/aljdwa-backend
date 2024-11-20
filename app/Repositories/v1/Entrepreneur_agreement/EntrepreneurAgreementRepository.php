<?php

namespace App\Repositories\v1\Entrepreneur_agreement;

use App\helpers\appHelpers;
use App\Models\EntrepreneurAgreement;
use App\Models\EntrepreneurDetail;
use App\Models\User;
use App\Models\Payment;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

use Illuminate\Support\Facades\Mail;
use App\Mail\AgreementNotification;
use App\Mail\AgreementResponseNotification;

class EntrepreneurAgreementRepository implements EntrepreneurAgreementInterface
{
    public function createEntrepreneurAgreement(array $data)
    {

        $entrepreneur_details_id = $data['entrepreneur_details_id'];

        $entrepreneur = EntrepreneurDetail::with('user')
       ->where('id',$entrepreneur_details_id)->first();

        $file = $data['agreement_document'];
        $data['admin_id'] =  Auth::id();
        $filePath = null;
        if (isset($data['agreement_document'])) {
            $fileInfo['user_id'] = $entrepreneur['user_id']; 
            $fileInfo['file'] = $data['agreement_document']; 
            $fileInfo['fileName'] = 'agreement_document'; 
            $filePath = appHelpers::uploadFile($fileInfo);
            $data['agreement_document'] = $filePath;
        }

        $agreement = EntrepreneurAgreement::create($data);

        // Send email notification to the entrepreneur user
        $user = User::find($entrepreneur['user']['id']); // Assuming user_id is passed in $data
        $userName = $user->founder_name;
        $agreementDetails = $data['agreement_details'] ?? null;
        $agreementDocumentPath = $filePath ?? null;

        $notification = [
            'sender_id' => Null ,
            'receiver_id' => $user['id'], 
            'message'           => "An agreement has been created for you by Admin.",
            'notification_type' => 'agreement',
        ];
        appHelpers::addNotification($notification); 

        // Mail::to($user->email)->send(new AgreementNotification($userName, $agreementDetails, $agreementDocumentPath));

        return $agreement;
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

    public function updateEntrepreneurAgreement(array $data)
    {

        $userId = Auth::id();
        $data['signed_At'] = Carbon::now()->toDateTimeString();
        $data['status'] = appHelpers::lookUpId('Agreement_status',$data['status']);
        $agreement = EntrepreneurAgreement::with([
            'agreement_status',
            'agreement_entrepreneur_detail'
        ])->whereHas('agreement_entrepreneur_detail', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })->first();
        
        if ($agreement && $agreement->update($data)) {
            $updatedAgreement = $agreement->fresh(
                ['agreement_status', ////entrepreneur_agreement -> lookup_details,
                'agreement_entrepreneur_detail',
                'agreement_entrepreneur_detail.user',
               ]);

            // Get the user's response status (accepted/rejected)
            // $responseStatus = $updatedAgreement['agreement_status']['value'];
            // $userName = $updatedAgreement->agreement_entrepreneur_detail->user->founder_name ?? 'User';
            // $agreementDetails = $updatedAgreement->agreement_details;

            $userName = $updatedAgreement->agreement_entrepreneur_detail->user->founder_name;
            $status = appHelpers::lookUpValue($updatedAgreement['status']); 
            $notification = [
                'sender_id' =>  $userId,
                'receiver_id' => NULL, 
                'message'           => "Agreement $status by $userName.",
                'notification_type' => 'agreement',
            ];
            appHelpers::addNotification($notification); 

            // Define the admin email
            // $adminEmail = config('mail.admin_email');

            // Send the email to admin about the user's response
            // Mail::to($adminEmail)->send(new AgreementResponseNotification($userName, $agreementDetails, $responseStatus));

            return $updatedAgreement;   
        }
  
        return false;
    }

    /*********** Admin Section - Agreements ***********/
    public function getAllAgreements(object $data = null)
    {

        $limit    = $data->input('limit', 10);
        $offset   = $data->input('offset', 0);
        $status   = $data->input('status')   ? appHelpers::lookUpId('Agreement_status',$data->input('status'))   : NULL;
        $fromDate = $data->input('fromDate') ? Carbon::createFromTimestamp($data->input('fromDate'))->startOfDay() : NULL;
        $toDate   = $data->input('toDate')   ? Carbon::createFromTimestamp($data->input('toDate'))->endOfDay()     : NULL;

        // $totalCount = EntrepreneurAgreement::has('agreement_entrepreneur_detail')->count();

        $query = EntrepreneurAgreement::with([
            'agreement_entrepreneur_detail',  // Fetches entrepreneur details for the agreement
            'agreement_status',               // Fetches agreement status (e.g., lookup details)
            'agreement_entrepreneur_detail.entrepreneur_details_payment', // Fetches payments related to entrepreneur details
            'agreement_entrepreneur_detail.entrepreneur_details_payment.payment_status', // Fetches status of each payment
        ])
        ->has('agreement_entrepreneur_detail');

        if ($status) {
            $query->where('entrepreneur_agreement.status',$status);
        }
        
        if ($fromDate || $toDate) {

            if ($fromDate) {
                $query->where('created_at', '>=', $fromDate);
            }
            if ($toDate) {
                $query->where('created_at', '<=', $toDate);
            }
        }
        $result = $query->orderBy('created_at','desc')
        ->limit($limit)
        ->offset($offset)
        ->get();

        $totalCount = $query->count();

        return [
            'totalCount' => $totalCount,
            'limit' => $limit,
            'offset' => $offset,
            'result' => $result
        ];        
    }

    public function getAgreement(int $agreementId)
    {
        return EntrepreneurAgreement::with([
            'agreement_entrepreneur_detail',  // Fetches entrepreneur details for the agreement
            'agreement_status',               // Fetches agreement status (e.g., lookup details)
            'agreement_entrepreneur_detail.entrepreneur_details_payment', // Fetches payments related to entrepreneur details
            'agreement_entrepreneur_detail.entrepreneur_details_payment.payment_status', // Fetches status of each payment
        ])
        ->where('id',$agreementId)
        ->first();         
    }
}

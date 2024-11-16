<?php

namespace App\Repositories\v1\Entrepreneur_details;

use App\helpers\appHelpers;
use App\Models\User;
use App\Models\EntrepreneurDetail;
use App\Models\ApplicationStatus;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserStatusNotification;


use Illuminate\Support\Carbon;

class EntrepreneurDetailsRepository implements EntrepreneurDetailsInterface
{
    public function createEntrepreneurDetails(array $data)
    {

        if (isset($data['resume'])) {
            $fileInfo['user_id'] = $data['user_id']; 
            $fileInfo['file'] = $data['resume']; 
            $fileInfo['fileName'] = 'resume'; 
            $filePath = appHelpers::uploadFile($fileInfo);
            $data['resume'] = $filePath;
        }

        if (isset($data['business_model'])) {
            $fileInfo['user_id'] = $data['user_id']; 
            $fileInfo['file'] = $data['business_model']; 
            $fileInfo['fileName'] = 'business_model'; 
            $filePath = appHelpers::uploadFile($fileInfo);
            $data['business_model'] = $filePath;
        }

        if (isset($data['patent'])) {
            $fileInfo['user_id'] = $data['user_id']; 
            $fileInfo['file'] = $data['patent']; 
            $fileInfo['fileName'] = 'patent'; 
            $filePath = appHelpers::uploadFile($fileInfo);
            $data['patent'] = $filePath;
        }
        return EntrepreneurDetail::create($data);
    }

    public function getEntrepreneurApplications(object $data)
    {

        $limit    = $data->input('limit', 10);
        $offset   = $data->input('offset', 0);
        $status   = $data->input('status')   ? appHelpers::lookUpId('Application_status',$data->input('status'))   : NULL;
        $fromDate = $data->input('fromDate') ? Carbon::createFromTimestamp($data->input('fromDate'))->startOfDay() : NULL;
        $toDate   = $data->input('toDate')   ? Carbon::createFromTimestamp($data->input('toDate'))->endOfDay()     : NULL;
        $search   = $data->input('search') ?? NULL;

        $totalCount = User::has('entreprenuer_details');

        $entrepreneur_applications = User::with([
            'entreprenuer_details',
            'user_role',
            'user_status',
            'latest_application_status',
            'latest_application_status.application_status'
        ])
        ->has('entreprenuer_details');
        
        // Ensure only users with entrepreneur details are fetched
        if ($status) {
            $entrepreneur_applications->where('users.status',$status);
            $totalCount = $totalCount->where('users.status',$status);
        }
        
        if ($fromDate || $toDate) {

            if ($fromDate) {
                $entrepreneur_applications->where('created_at', '>=', $fromDate);
                $totalCount = $totalCount->where('users.created_at', '>=', $fromDate);
            }
            if ($toDate) {
                $entrepreneur_applications->where('created_at', '<=', $toDate);
                $totalCount = $totalCount->where('users.created_at', '<=', $toDate);
            }
        }

        if ($search) {
            $entrepreneur_applications = $entrepreneur_applications->where(function ($query) use ($search) {
                $query->where('founder_name', 'LIKE', "%{$search}%")
                      ->orWhere('email', 'LIKE', "%{$search}%")
                      ->orWhere('phone_number', 'LIKE', "%{$search}%");
            });
    
            $totalCount = $totalCount->where(function ($query) use ($search) {
                $query->where('founder_name', 'LIKE', "%{$search}%")
                      ->orWhere('email', 'LIKE', "%{$search}%")
                      ->orWhere('phone_number', 'LIKE', "%{$search}%");
            });
        }


        $entrepreneur_applications = $entrepreneur_applications->orderBy('created_at','desc')
        ->limit($limit)
        ->offset($offset)
        ->get();

        $totalCount = $totalCount->count();

        return [
            'totalCount' => $totalCount,
            'limit' => $limit,
            'offset' => $offset,
            'entrepreneur_applications' => $entrepreneur_applications
        ];    
    }

    public function reviewEntrepreneurApplication(string $applicationId = null)
    {
        return User::with([
            'entreprenuer_details', 
            'user_role',  
            'user_status',
            'user_application_status' => function ($query) {
                $query->latest('id')->limit(1); // Fetch only the latest user_application_status record
            },
            'user_application_status.application_status',
            'entreprenuer_details.entrepreneur_details_agreement',
            'entreprenuer_details.entrepreneur_details_agreement.agreement_status',
            'entreprenuer_details.entrepreneur_details_payment',
            'entreprenuer_details.entrepreneur_details_payment.payment_status',
        ])
            ->has('entreprenuer_details') 
            ->where('id',$applicationId)->first();
    }

    // Entrepreneur will update his application
    public function updateEntrepreneurApplication(array $data, string $applicationId)
    {
        $entrepreneurDetail = EntrepreneurDetail::where('user_id', $applicationId)->first();

        if ($entrepreneurDetail && $entrepreneurDetail->update($data)) {
            return $entrepreneurDetail;
        }

        return false;
          
    }

}

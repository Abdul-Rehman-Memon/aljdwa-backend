<?php

namespace App\Repositories\v1\Entrepreneur_details;

use App\helpers\appHelpers;
use App\Models\User;
use App\Models\EntrepreneurDetail;
use App\Models\CoFounder;
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

    public function createCoFounders(array $data)
    {
        
        // return $data;
        foreach($data as $key=>$value){

            $record = [
                'co_founder_name' => $value['co_founder_name'],
                'position'        => $value['position'],
                'major'           => $value['major'],
            ];
            $record['user_id'] = $data['user_id'];

            if (isset($value['resume'])) {
                $fileInfo['user_id'] = $record['user_id']; 
                $fileInfo['file'] = $value['resume']; 
                $fileInfo['fileName'] = 'co_founder_resume'; 
                $filePath = appHelpers::uploadFile($fileInfo);
                $record['resume'] = $filePath;
            }  
            return CoFounder::create($record);
        }
    }

    public function updateCoFounders(array $data,string $userId)
    {
        foreach($data as $key=>$value){

            // $co_founder = CoFounder::find($value['co_founder_id']);
            $co_founder = CoFounder::where(['id'=>$value['co_founder_id'] , 'user_id' => $userId])
                ->first();

            if ($co_founder) {

                if (isset($value['resume'])) {
                    $fileInfo['user_id'] = $co_founder->user_id; 
                    $fileInfo['file'] = $value['resume']; 
                    $fileInfo['fileName'] = 'resume'; 
                    $filePath = appHelpers::uploadFile($fileInfo);
                    $value['resume'] = $filePath;
                }

                return $co_founder->update($value);
            }
        }
    }

    public function getEntrepreneurApplications(object $data)
    {

        $limit    = $data->input('limit', 10);
        $offset   = $data->input('offset', 0);
        $status   = $data->input('status')   ? appHelpers::lookUpId('Application_status',$data->input('status'))   : NULL;
        $fromDate = $data->input('fromDate') ? Carbon::createFromTimestamp($data->input('fromDate'))->startOfDay() : NULL;
        $toDate   = $data->input('toDate')   ? Carbon::createFromTimestamp($data->input('toDate'))->endOfDay()     : NULL;
        $search   = $data->input('search') ?? NULL;


        $result = User::with([
            'user_role',
            'user_status',
            'co_founders',
            'entreprenuer_details.entrepreneur_details_agreement.agreement_status',
            'entreprenuer_details.entrepreneur_details_payment.payment_status',
            'latest_application_status.application_status',
        ])
        ->has('entreprenuer_details');
        
        // Ensure only users with entrepreneur details are fetched
        if ($status) {
            $result->where('users.status',$status);
        }
        
        if ($fromDate || $toDate) {

            if ($fromDate) {
                $result->where('created_at', '>=', $fromDate);
            }
            if ($toDate) {
                $result->where('created_at', '<=', $toDate);
            }
        }

        if ($search) {
                $result->where(function ($query) use ($search) {
                $query->where('founder_name', 'LIKE', "%{$search}%")
                      ->orWhere('email', 'LIKE', "%{$search}%")
                      ->orWhere('phone_number', 'LIKE', "%{$search}%");
            });
        }


        $result = $result->orderBy('created_at','desc')
        ->limit($limit)
        ->offset($offset)
        ->get();

        $totalCount = $result->count();

        return [
            'totalCount' => $totalCount,
            'limit' => $limit,
            'offset' => $offset,
            'result' => $result
        ];    
    }

    public function reviewEntrepreneurApplication(string $applicationId = null)
    {
        return User::with([
            'user_role',  
            'user_status',
            'co_founders',
            'entreprenuer_details.entrepreneur_details_agreement.agreement_status',
            'entreprenuer_details.entrepreneur_details_payment.payment_status',
            'latest_application_status.application_status',
        ])
            ->has('entreprenuer_details') 
            ->where('id',$applicationId)->first();
    }

    // Entrepreneur will update his application
    public function updateEntrepreneurApplication(array $data, string $applicationId)
    {
        $entrepreneurDetail = EntrepreneurDetail::where('user_id', $applicationId)->first();

        if (isset($data['resume'])) {
            $fileInfo['user_id'] = $applicationId; 
            $fileInfo['file'] = $data['resume']; 
            $fileInfo['fileName'] = 'resume'; 
            $filePath = appHelpers::uploadFile($fileInfo);
            $data['resume'] = $filePath;
        }

        if (isset($data['business_model'])) {
            $fileInfo['user_id'] = $applicationId; 
            $fileInfo['file'] = $data['business_model']; 
            $fileInfo['fileName'] = 'business_model'; 
            $filePath = appHelpers::uploadFile($fileInfo);
            $data['business_model'] = $filePath;
        }

        if (isset($data['patent'])) {
            $fileInfo['user_id'] = $applicationId; 
            $fileInfo['file'] = $data['patent']; 
            $fileInfo['fileName'] = 'patent'; 
            $filePath = appHelpers::uploadFile($fileInfo);
            $data['patent'] = $filePath;
        }

        if ($entrepreneurDetail && $entrepreneurDetail->update($data)) {
            return $entrepreneurDetail;
        }

        return false;
          
    }

}

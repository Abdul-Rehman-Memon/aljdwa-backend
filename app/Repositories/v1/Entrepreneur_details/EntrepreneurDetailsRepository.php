<?php

namespace App\Repositories\v1\Entrepreneur_details;

use App\Models\User;
use App\Models\EntrepreneurDetail;
use App\Models\ApplicationStatus;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserStatusNotification;

class EntrepreneurDetailsRepository implements EntrepreneurDetailsInterface
{
    public function createEntrepreneurDetails(array $data)
    {

        if (isset($data['resume'])) {
            $fileInfo['user_id'] = $data['user_id']; 
            $fileInfo['file'] = $data['resume']; 
            $fileInfo['fileName'] = 'resume'; 
            $filePath = $this->uploadEntrepreneurDetailsFile($fileInfo);
            $data['resume'] = $filePath;
        }

        if (isset($data['business_model'])) {
            $fileInfo['user_id'] = $data['user_id']; 
            $fileInfo['file'] = $data['business_model']; 
            $fileInfo['fileName'] = 'business_model'; 
            $filePath = $this->uploadEntrepreneurDetailsFile($fileInfo);
            $data['business_model'] = $filePath;
        }

        if (isset($data['patent'])) {
            $fileInfo['user_id'] = $data['user_id']; 
            $fileInfo['file'] = $data['patent']; 
            $fileInfo['fileName'] = 'patent'; 
            $filePath = $this->uploadEntrepreneurDetailsFile($fileInfo);
            $data['patent'] = $filePath;
        }
        return EntrepreneurDetail::create($data);
    }

    public function getEntrepreneurApplications($limit, $offset)
    {
        $totalCount = User::has('entreprenuer_details')->count();

        $entrepreneur_applications = User::with([
            'entreprenuer_details',
            'user_role',
            'user_status',
            'user_application_status' => function ($query) {
                $query->latest('id')->limit(1); // Fetch only the latest user_application_status record
            },
            'user_application_status.application_status'
        ])
        ->has('entreprenuer_details') // Ensure only users with entrepreneur details are fetched
        ->orderBy('created_at','desc')
        ->limit($limit)
        ->offset($offset)
        ->get();

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

    // public function updateEntrepreneurApplicationStatusByAdmin(array $data, string $applicationId)
    // {
    //     $data['user_id'] = $applicationId;
    //     $data['status_by'] = Auth::user()->id;

    //     $application_status = ApplicationStatus::create($data);
        
    //     $user = User::find($data['user_id']);
       
    //     if ($user) {
    //         $user = $user->load([
    //             'user_application_status' => function ($query) {
    //                 $query->latest('id')->limit(1); // Fetch only the latest user_application_status record
    //             },
    //             'user_application_status.application_status'
    //         ]);
    //         $status = $user['user_application_status'][0]['application_status']['value']?? null;
    //         Mail::to($user->email)->send(new UserStatusNotification($user->founder_name, $status));
    //     }
        
    //     return $application_status;
          
    // }

    // Entrepreneur will update his application
    public function updateEntrepreneurApplication(array $data, string $applicationId)
    {
        $entrepreneurDetail = EntrepreneurDetail::where('user_id', $applicationId)->first();

        if ($entrepreneurDetail && $entrepreneurDetail->update($data)) {
            return $entrepreneurDetail;
        }

        return false;
          
    }

    public function uploadEntrepreneurDetailsFile(array $data)
    {

        $userRole = 'entrepreneur';
        $userId = $data['user_id'];
        $file = $data['file'];
        $fileName = $data['fileName'];
        // Define the directory path: user_role/user_id/fileName/
        $directory = "public/{$userRole}/{$userId}/{$fileName}";

        // Check if directory exists, create it if it doesn’t
        if (!File::exists(storage_path("app/{$directory}"))) {
            File::makeDirectory(storage_path("app/{$directory}"), 0755, true);
        }

        $timestamp = time();
        $filePath = Storage::disk('public')->putFileAs($directory, $file, "{$timestamp}.{$file->getClientOriginalExtension()}");

         // Generate the full URL for accessing the file
        $fullUrl = asset("storage/" . str_replace('public/', '', $filePath));

        return $fullUrl;
    }
}

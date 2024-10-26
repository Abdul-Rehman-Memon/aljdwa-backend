<?php

namespace App\Repositories\v1\Entrepreneur_details;

use App\Models\User;
use App\Models\EntrepreneurDetail;
use App\Models\ApplicationStatus;
use Illuminate\Support\Facades\Auth;

class EntrepreneurDetailsRepository implements EntrepreneurDetailsInterface
{
    public function createEntrepreneurDetails(array $data)
    {
        return EntrepreneurDetail::create($data);
    }

    public function getEntrepreneurApplications($limit, $offset)
    {
        $totalCount = User::has('entreprenuer_details')->count();

        $entrepreneur_applications = User::with(['entreprenuer_details', 'user_role', 'user_status',])
        ->has('entreprenuer_details') // Ensure only users with entrepreneur details are fetched
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

    public function reviewEntrepreneurApplication(string $applicationId)
    {
        return User::with(['entreprenuer_details', 'user_role', 'user_status',])
            ->has('entreprenuer_details') 
            ->where('id',$applicationId)->first();
    }

    public function updateEntrepreneurApplication(array $data, string $applicationId)
    {
        $data['user_id'] = $applicationId;
        $data['status_by'] = Auth::user()->id;
        return ApplicationStatus::create($data);  
          
    }
}

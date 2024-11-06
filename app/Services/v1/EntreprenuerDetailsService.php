<?php
namespace App\Services\v1;

use App\Repositories\v1\Users\UserRepositoryInterface;
use App\Repositories\v1\Entrepreneur_details\EntrepreneurDetailsInterface;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Mail;
use App\Mail\UserProfileUpdatedNotification;

use DB;

class EntreprenuerDetailsService
{
    protected $userRepository;
    protected $entreprenuerDetailsRepository;

    public function __construct(
        UserRepositoryInterface $userRepository,
        EntrepreneurDetailsInterface $entreprenuerDetailsRepository
        )
    {
        $this->userRepository = $userRepository;
        $this->entreprenuerDetailsRepository = $entreprenuerDetailsRepository;
    }

    public function getEntrepreneurApplications($limit, $offset)
    {
        $applications = $this->entreprenuerDetailsRepository->getEntrepreneurApplications($limit, $offset);

        return $applications;
    }

    public function reviewEntrepreneurApplication($applicationId)
    {
        $application = $this->entreprenuerDetailsRepository->reviewEntrepreneurApplication($applicationId);

        return $application;
    }

    public function updateEntrepreneurApplicationStatusByAdmin($data, $applicationId)
    {
        $application = $this->entreprenuerDetailsRepository->updateEntrepreneurApplicationStatusByAdmin($data, $applicationId);

        return $application;
    }

    public function updateEntrepreneurApplication($data, $applicationId)
    {
        $applicationId = Auth::user()->id;

        DB::beginTransaction();

        try {
            // Update user data
            $userUpdated = $this->userRepository->updateUser($data, $applicationId);

            if (!$userUpdated) {
                DB::rollBack();
                return false; // If user update fails, rollback
            }

            // Update entrepreneur details
            $entrepreneurUpdated = $this->entreprenuerDetailsRepository->updateEntrepreneurApplication($data,$applicationId);

            if (!$entrepreneurUpdated) {
                DB::rollBack();
                return false; // Rollback if entrepreneur update fails
            }

            $applicationData['status'] = 13;//resubmit
            $applicationData['user_id'] = $applicationId;
            $applicationData['status_by'] = $applicationId;//here user update his status

            $applicationStatus = $this->userRepository->applicationStatus($applicationData);
            if (!$applicationStatus) {
                DB::rollBack();
                return false; // Rollback if entrepreneur update fails
            }

            DB::commit(); // Commit if both updates succeed
         
            // Reload 'entrepreneur_details' to ensure it reflects any recent changes
            $userUpdated = $userUpdated->fresh([
                'entreprenuer_details',
                'user_role',
                'user_status',
                'user_application_status' => function ($query) {
                    $query->latest('id')->limit(1); // Fetch only the latest user_application_status record
                },
                'user_application_status.application_status'
            ]);

            return $userUpdated;

        } catch (\Exception $e) {
            DB::rollBack(); // Rollback on any exception
            throw new \Exception('An error occurred: ' . $e->getMessage().' Line '.$e->getLine());
        }
    }
}

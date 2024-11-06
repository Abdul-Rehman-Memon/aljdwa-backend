<?php
namespace App\Services\v1;

use App\helpers\appHelpers;
use App\Models\User;
use App\Models\ApplicationStatus;
use App\Repositories\v1\Users\UserRepositoryInterface;
use App\Repositories\v1\Entrepreneur_details\EntrepreneurDetailsInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Mail;
use App\Mail\UserStatusNotification;


class UserService
{
    protected $userRepository;
    protected $entrepreneurDetailsRepository;

    public function __construct(UserRepositoryInterface $userRepository, EntrepreneurDetailsInterface $entrepreneurDetailsRepository)
    {
        $this->userRepository = $userRepository;
        $this->entrepreneurDetailsRepository = $entrepreneurDetailsRepository;
    }

    public function registerUser(array $data)
    {  
        // Use a transaction to ensure data integrity
        return DB::transaction(function () use ($data) {
            // Create user and get the user instance
            $data['password'] = Hash::make($data['password']);
            $data['role'] = appHelpers::lookUpId('role',$data['role']) ?? 3; 

            $user = $this->userRepository->createUser($data);
            $application_status = ['status' => 11,'user_id' => $user->id];
            $application = $this->userRepository->applicationStatus($application_status);

            if($user->user_role->value === 'entrepreneur'){
               // Prepare entrepreneur detail data, make sure to handle optional fields
                $entrepreneurDetailData = [
                    'user_id' => $user->id, // Set the user ID here
                    'position' => $data['position'] ?? null,
                    'major' => $data['major'] ?? null,
                    'resume' => $data['resume'] ?? null,
                    'website' => $data['website'] ?? null,
                    'project_description' => $data['project_description'] ?? null,
                    'problem_solved' => $data['problem_solved'] ?? null,
                    'solution_offering' => $data['solution_offering'] ?? null,
                    'previous_investment' => $data['previous_investment'] ?? null,
                    'industry_sector' => $data['industry_sector'] ?? null,
                    'business_model' => $data['business_model'] ?? null,
                    'patent' => $data['patent'] ?? null,
                ];

                // Create entrepreneur details using the entrepreneurDetailsRepository
                $this->entrepreneurDetailsRepository->createEntrepreneurDetails($entrepreneurDetailData);
            }
            // Return the user instance, which is successful
            return $user->load('user_application_status.application_status');
        });
    }

    public function forgetPassword(array $data){

        return $this->userRepository->forgetPassword($data);
    }

    public function getMentorApplications($limit, $offset){

        return $this->userRepository->getMentorApplications($limit, $offset);
    }

    public function reviewMentorApplication($applicationId){

        return $this->userRepository->reviewMentorApplication($applicationId);
    }

    public function updateApplicationStatusByAdmin(array $data, string $applicationId){
        $data['user_id'] = $applicationId;
        $data['status_by'] = Auth::user()->id;

        $application_status = $this->userRepository->applicationStatus($data);

        if($application_status){
            $user = User::find($data['user_id']);
       
            if ($user) {
                $user = $user->load([
                    'user_application_status' => function ($query) {
                        $query->latest('id')->limit(1); // Fetch only the latest user_application_status record
                    },
                    'user_application_status.application_status'
                ]);
                $status = $user['user_application_status'][0]['application_status']['value']?? null;
                // Mail::to($user->email)->send(new UserStatusNotification($user->founder_name, $status));
            }
        }
         
        return $application_status;
    }

    public function getUser($userId){

        return $this->userRepository->getUser($userId);
    }
}

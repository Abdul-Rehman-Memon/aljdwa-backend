<?php
namespace App\Services\v1;

use App\helpers\appHelpers;
use App\Repositories\v1\Users\UserRepositoryInterface;
use App\Repositories\v1\Entrepreneur_details\EntrepreneurDetailsInterface;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
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

    public function getUser($userId){

        return $this->userRepository->getUser($userId);
    }
}

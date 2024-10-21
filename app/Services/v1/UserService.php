<?php
namespace App\Services\v1;

use App\Repositories\v1\Users\UserRepositoryInterface;
use App\Repositories\v1\Entreprenuer_details\EntreprenuerDetailsInterface;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
class UserService
{
    protected $userRepository;
    protected $entreprenuerDetailsRepository;

    public function __construct(UserRepositoryInterface $userRepository, EntreprenuerDetailsInterface $entreprenuerDetailsRepository)
    {
        $this->userRepository = $userRepository;
        $this->entreprenuerDetailsRepository = $entreprenuerDetailsRepository;
    }

    public function registerUser(array $data)
    {
        
        // Use a transaction to ensure data integrity
        return DB::transaction(function () use ($data) {
            // Create user and get the user instance
            // Hash the password before saving
            $data['password'] = Hash::make($data['password']);
            $user = $this->userRepository->createUser($data);

            if($user->user_role->value == 'Entreprenuer'){
            // Prepare entreprenuer detail data, make sure to handle optional fields
                $entreprenuerDetailData = [
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

                // Create entreprenuer details using the EntrepreneurDetailsRepository
                $this->entreprenuerDetailsRepository->createEntreprenuerDetails($entreprenuerDetailData);
            }
            // Return the user instance, which is successful
            return $user;
        });
    }
}

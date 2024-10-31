<?php

namespace App\Repositories\v1\Users;

use App\Models\User;
use App\Models\ApplicationStatus;
use App\Mail\UserRegistered;
use Illuminate\Support\Facades\Mail;

class UserRepository implements UserRepositoryInterface
{
    public function createUser(array $data)
    {
        $user = User::create($data);
    
        // Define verification URL
        // $verification_url = route('verify.email', ['token' => $user->email_verification_token]);
    
        // Send email
        // Mail::to($user->email)->send(new UserRegistered($user->founder_name));
        // Load the roles relationship
        return $user->load(['user_role','user_status']); // This loads the roles after creating the user

    }

    public function applicationStatus(array $data)
    {
        return ApplicationStatus::create($data);
    }

    public function updateUser(array $data, string $userId)
    {
        $user = User::find($userId);
       
        // Load the roles relationship
        if ($user && $user->update($data)) {
            // Send email
            // Mail::to($user->email)->send(new UserRegistered($user->founder_name));
            // Load the 'entrepreneur_details' relationship            
            return $user->load([
                'entreprenuer_details',
                'user_role',
                'user_status',
                'user_application_status' => function ($query) {
                    $query->latest('id')->limit(1); // Fetch only the latest user_application_status record
                },
                'user_application_status.application_status'
            ]);
        }

        return false;
    }

    public function getUser(string $userId)
    {
        return User::find($userId)->load('user_role');
    }

}

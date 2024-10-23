<?php

namespace App\Repositories\v1\Users;

use App\Models\User;
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
        Mail::to($user->email)->send(new UserRegistered($user->founder_name));
        // Load the roles relationship
        return $user->load(['user_role','user_status']); // This loads the roles after creating the user

    }
}

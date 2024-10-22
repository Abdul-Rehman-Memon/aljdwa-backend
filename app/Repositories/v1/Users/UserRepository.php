<?php

namespace App\Repositories\v1\Users;

use App\Models\User;

class UserRepository implements UserRepositoryInterface
{
    public function createUser(array $data)
    {
        $user = User::create($data);
        // Load the roles relationship
        return $user->load(['user_role','user_status']); // This loads the roles after creating the user

    }
}

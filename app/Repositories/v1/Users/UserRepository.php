<?php

namespace App\Repositories\v1\Users;

use App\helpers\appHelpers;
use App\Models\User;
use App\Models\ApplicationStatus;
use App\Mail\UserRegistered;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Exception;
use App\Mail\ResetPasswordEmail;
use App\Mail\NewUserRegistrationForAdmin;
use App\Mail\UserWelcomeNotification;
use App\Mail\UserStatusNotification;
use App\Mail\UserProfileUpdatedNotification;

class UserRepository implements UserRepositoryInterface
{
    public function createUser(array $data)
    {

        $user = User::create($data);

        // Send email to the admin
        $adminEmail = config('mail.admin_email'); // Make sure the admin email is set in .env as MAIL_ADMIN_EMAIL
        if ($adminEmail) {
            Mail::to($adminEmail)->send(new NewUserRegistrationForAdmin($user->founder_name, $user->email));
        }
    
        // Send welcome email to the user
        Mail::to($user->email)->send(new UserWelcomeNotification($user->founder_name));
    
        // Load additional relationships if needed
        return $user->load(['user_role', 'user_status']);

    }

    public function forgetPassword(array $data)
    {
        $user = User::where('email',$data['email'])->first();

        if (!$user) {
            return null;
        }
        $newPassword = Str::random(10);

        // Hash and update the new password for the user
        $user->password = bcrypt($newPassword);
        $user->save();

        // Send an email to the user with the new password
        $this->sendPasswordResetEmail($user, $newPassword);

        return $user;
    }

    protected function sendPasswordResetEmail(User $user, string $newPassword)
    {
        $toEmail = $user->email;

        // Send an email to the user with the new password
        Mail::to($toEmail)->send(new ResetPasswordEmail($user, $newPassword)); // Pass the user object and the new password
    }

    public function applicationStatus(array $data)
    {
        return ApplicationStatus::create($data);
    }

    public function getMentorApplications($limit, $offset)
    {

        $totalCount = User::where('role',2)->count();
        $users = User::with([
            'entreprenuer_details',
            'user_role',
            'user_status',
            'user_application_status' => function ($query) {
                $query->latest('id')->limit(1); // Fetch only the latest user_application_status record
            },
            'user_application_status.application_status'
        ])
        ->where('role',2) //2 = mentor
        ->limit($limit)
        ->offset($offset)
        ->get();

        return [
            'totalCount' => $totalCount,
            'limit' => $limit,
            'offset' => $offset,
            'users' => $users
        ]; 
    }

    public function reviewMentorApplication(string $applicationId)
    {
        $user = User::where('role',2)->find($applicationId);
        return $user ? $user->load([
            'user_role',
            'user_status',
            'user_application_status' => function ($query) {
                $query->latest('id')->limit(1); // Fetch only the latest user_application_status record
            },
            'user_application_status.application_status'
        ]) : null;
    }

    public function getUser(string $userId)
    {
        $user = User::find($userId);
        return $user ? $user->load('user_role') : null;
    }

    public function updateUser(array $data, string $userId)
    {
       
        $user = User::find($userId);
       
        if ($user && $user->update($data)) {

            $user['status'] = 'resubmit';

            $adminEmail = config('mail.admin_email');
            Mail::to($adminEmail)->send(new UserProfileUpdatedNotification($user));
            return $user;
        }

        return false;
    }

}

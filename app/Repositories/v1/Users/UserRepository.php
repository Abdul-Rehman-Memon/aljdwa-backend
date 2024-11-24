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
use Illuminate\Support\Facades\Auth;


use Illuminate\Support\Carbon;

class UserRepository implements UserRepositoryInterface
{
    public function createUser(array $data)
    {
        $user = User::create($data);

        if (isset($data['profile_photo'])) {
            $fileInfo['user_id'] = $user->id; 
            $fileInfo['file'] = $data['profile_photo']; 
            $fileInfo['fileName'] = 'profile_photo'; 
            $filePath = appHelpers::uploadFile($fileInfo);
            $data['profile_photo'] = $filePath;

            $user->update(['profile_photo' => $filePath]);
        } 

        

        $notification = [
            'sender_id' => NULL ,
            'receiver_id' => NULL, 
            'message'           => 'A new application request has been submitted by '. $data['founder_name'],
            'notification_type' => 'application_request',
        ];
        appHelpers::addNotification($notification); 

        // Send email to the admin
        // $adminEmail = config('mail.admin_email'); // Make sure the admin email is set in .env as MAIL_ADMIN_EMAIL
        // if ($adminEmail) {
        //     Mail::to($adminEmail)->send(new NewUserRegistrationForAdmin($user->founder_name, $user->email));
        // }
    
        // Send welcome email to the user
        // Mail::to($user->email)->send(new UserWelcomeNotification($user->founder_name));
    
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
        // Mail::to($toEmail)->send(new ResetPasswordEmail($user, $newPassword)); // Pass the user object and the new password
    }

    public function applicationStatus(array $data)
    {
        $status = appHelpers::lookUpValue($data['status']); 
        $notification = [
            'sender_id' => Null ,
            'receiver_id' => $data['user_id'], 
            'message'           => "Your Application status updated as $status by Admin.",
            'notification_type' => 'application_request',
        ];
        appHelpers::addNotification($notification); 
        return ApplicationStatus::create($data);
    }

    public function getMentorApplications(object $data)
    {

        $limit    = $data->input('limit', 10);
        $offset   = $data->input('offset', 0);
        $status   = $data->input('status')   ? appHelpers::lookUpId('Application_status',$data->input('status'))   : NULL;
        $fromDate = $data->input('fromDate') ? Carbon::createFromTimestamp($data->input('fromDate'))->startOfDay() : NULL;
        $toDate   = $data->input('toDate')   ? Carbon::createFromTimestamp($data->input('toDate'))->endOfDay()     : NULL;
        $search   = $data->input('search') ?? NULL;

        $users = User::with([
            'entreprenuer_details',
            'user_role',
            'user_status',
            'latest_application_status.application_status'
        ])
        ->where('role',2);//2 = mentor
        
        // Ensure only users with entrepreneur details are fetched
        if ($status) {
            $users->whereHas('latest_application_status.application_status', function ($query) use ($status) {
                $query->where('status', $status); // Adjust 'status' to the actual column name
            });
        }
        
        if ($fromDate || $toDate) {

            if ($fromDate) {
                $users->where('created_at', '>=', $fromDate);
            }
            if ($toDate) {
                $users->where('created_at', '<=', $toDate);
            }
        }

        if ($search) {
            $users->where(function ($query) use ($search) {
                $query->where('founder_name', 'LIKE', "%{$search}%")
                      ->orWhere('email', 'LIKE', "%{$search}%")
                      ->orWhere('phone_number', 'LIKE', "%{$search}%");
            });
        }

        $users = $users->orderBy('created_at','desc')
        ->limit($limit)
        ->offset($offset)
        ->get();

        $totalCount = $users->count();

        return [
            'totalCount' => $totalCount,
            'limit' => $limit,
            'offset' => $offset,
            'result' => $users
        ]; 
    }
 
    public function reviewMentorApplication(string $applicationId)
    {
        $user = User::where('role',2)->find($applicationId);
        return $user ? $user->load([
            'user_role',
            'user_status',
            'latest_application_status.application_status'
        ]) : null;
    }

    public function getUser(string $userId)
    {
        $user = User::find($userId);
        return $user ? $user->load('user_role') : null;
    }

    public function updateUser(array $data, string $userId)
    {
        $userId = Auth::user()->id;
        $user = User::find($userId);
       
        if ($user && $user->update($data)) {

            $applicationData['status'] = 13;//resubmit
            $applicationData['user_id'] = $userId;
            $applicationData['status_by'] = $userId;//here user update his status

            $applicationStatus = $this->applicationStatus($applicationData);
            if (!$applicationStatus) {
                DB::rollBack();
                return false; // Rollback if application status fails
            }

            $notification = [
                'sender_id' => $userId ,
                'receiver_id' => NULL, 
                'message'           => "The user $user->founder_name has updated their profile after it was returned for further modifications.",
                'notification_type' => 'application_request',
            ];
            appHelpers::addNotification($notification); 

            // $user['status'] = 'resubmit'; // it was used for email status 
            // $adminEmail = config('mail.admin_email');
            // Mail::to($adminEmail)->send(new UserProfileUpdatedNotification($user));

            return $user->load(['user_role','latest_application_status.application_status']);
        }

        return false;
    }

}

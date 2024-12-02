<?php

namespace App\Http\Controllers\Api;

use App\helpers\appHelpers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\LookupDetail;
use App\Http\Requests\v1\Users\RegisterRequest;
use App\Http\Requests\v1\Users\LoginRequest;
use App\Http\Requests\v1\Users\ForgetPasswordRequest;
use App\Services\v1\UserService;
use Illuminate\Database\QueryException;
use Exception;
use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Hash;
use App\Http\Helpers\ResponseHelper;

class AuthController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }
    // Register a new user
    public function register(RegisterRequest $request)
    {
        $validatedData = $request->validated();

        try {
            // Register user and associated entrepreneur details
            $user = $this->userService->registerUser($validatedData);
            return ResponseHelper::created($user,'User registered successfully');
        } catch (Exception $e) {
            // Handle the error
            return ResponseHelper::error('Failed to register user or entrepreneur details.',500,$e->getMessage());
        }
    }
    public function login(LoginRequest $request){

        $admin =  appHelpers::getAdmin();

        $user = User::with([
                'user_role', 'user_status',
                'co_founders', 
                'entreprenuer_details.user_entrepreneur_details_agreement.agreement_status',
                'entreprenuer_details.user_entrepreneur_details_payment.payment_status',
                'latest_application_status.application_status',
        ])
        ->where('email', $request->email)
        ->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return ResponseHelper::unauthorized('Invalid Email/Password.');
        }

        $user['chunk_id'] = $admin->id;

        // $applicationStatus = $user->user_application_status; 
        // $applicationStatus = $applicationStatus[0]; 
        // $applicationStatus = $applicationStatus->application_status->value; 

        // if($applicationStatus  === 'pending'){
        //     return ResponseHelper::forbidden('Your account is pending. Please wait for approval.');
        // }

        // Revoke all existing tokens
        $user->tokens()->delete();

        $token = $user->createToken('app')->plainTextToken;

        $user['token'] = $token; 

        return ResponseHelper::success($user ,'You are logged in');
    }

    public function forgetPassword(ForgetPasswordRequest $request)
    {
        $validatedData = $request->validated();

        try {
            // Send password recovery email
            $user = $this->userService->forgetPassword($validatedData);
            if(!$user)
            return ResponseHelper::notFound('No user found with the provided email address.');
        
            return ResponseHelper::created($user, 'An email has been sent to your email address to recover your password.');
        } catch (Exception $e) {
            // Handle the error
            return ResponseHelper::error('Failed to send password recovery email.', 500, $e->getMessage());
        }
    }
}

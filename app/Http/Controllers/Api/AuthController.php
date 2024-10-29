<?php

namespace App\Http\Controllers\Api;

use App\helpers\appHelpers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\LookupDetail;
use App\Http\Requests\v1\Users\RegisterRequest;
use App\Http\Requests\v1\Users\LoginRequest;
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

        $user = User::with([
                    'user_role', 'user_status', 
                    'user_application_status' => function ($query) {
                    $query->latest('id')->limit(1); // Fetch the last inserted record based on the ID
                },
                'user_application_status.application_status'
        ])
        ->where('email', $request->email)
        ->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return ResponseHelper::unauthorized('Invalid Email/Password.');
        }

        $applicationStatus = $user->user_application_status; 
        $applicationStatus = $applicationStatus[0]; 
        $applicationStatus = $applicationStatus->application_status->value; 

        // if($applicationStatus  === 'pending'){
        //     return ResponseHelper::forbidden('Your account is pending. Please wait for approval.');
        // }

        // Revoke all existing tokens
        $user->tokens()->delete();

        $token = $user->createToken('app')->plainTextToken;

        $user['token'] = $token; 

        return ResponseHelper::success($user ,'You are logged in');
    }
}

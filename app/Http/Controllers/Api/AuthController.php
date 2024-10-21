<?php

namespace App\Http\Controllers\Api;

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
            // Register user and associated startup details
            $user = $this->userService->registerUser($validatedData);
            return ResponseHelper::created($user,'User registered successfully');
        } catch (Exception $e) {
            // Handle the error, you can also log the error if necessary
            return ResponseHelper::error('Failed to register user or startup details.',500,$e->getMessage());
        }
    }
    public function login(LoginRequest $request){


        $user = User::with(['user_role','user_status'])
        ->where('email', $request->email)
        ->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return ResponseHelper::unauthorized('Invalid Email/Password.');
        }

        if($user->user_status->value == 'Pending'){
            return ResponseHelper::forbidden('Your account is pending. Please wait for approval.');
        }

        // Revoke all existing tokens
        $user->tokens()->delete();

        $token = $user->createToken('app')->plainTextToken;

        $user['token'] = $token; 

        return ResponseHelper::created($user ,'You are logged in');
    }
}

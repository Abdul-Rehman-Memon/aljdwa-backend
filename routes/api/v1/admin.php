<?php


use App\Http\Controllers\Api\V1\Admin\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/users', [UserController::class, 'index']); // List all users
    Route::get('/users/{id}', [UserController::class, 'show']); // View a specific user
    // Additional admin routes...
});

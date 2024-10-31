<?php

use App\Http\Controllers\Api\v1\MentorController;
use Illuminate\Support\Facades\Route;

use App\Http\Middleware\CheckRole;

Route::middleware(['auth:sanctum', CheckRole::class . ':Mentor'])->prefix('mentor')->group(function () {

    //Meetings
    // Route::prefix('meeting-management')->group(function () {
    //     Route::post('/meetings', [MentorController::class, 'createMeeting']);
    // });

    //Entrepreneur Assigned to Mentor
    Route::prefix('mentor-assignment-management')->group(function () {
        Route::get('/assigned-entrepreneur', [MentorController::class, 'getEntrepreneurAssignedToMentor']);
    });
});

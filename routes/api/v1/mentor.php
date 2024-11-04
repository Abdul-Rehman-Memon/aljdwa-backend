<?php

use App\Http\Controllers\Api\v1\MentorController;
use Illuminate\Support\Facades\Route;

use App\Http\Middleware\CheckRole;

Route::middleware(['auth:sanctum', CheckRole::class . ':Mentor'])->prefix('mentor')->group(function () {

    //Entrepreneur Assigned to Mentor
    Route::prefix('mentor-assignment-management')->group(function () {
        Route::get('/assigned-entrepreneur', [MentorController::class, 'getAllEntrepreneurAssignedToMentor']);
        Route::get('/assigned-entrepreneur/{id}', [MentorController::class, 'getEntrepreneurAssignedToMentor']);
    });

    //Meetings
    Route::prefix('meeting-management')->group(function () {
        Route::post('/meetings', [MentorController::class, 'createMeeting']);
        Route::get('/meetings', [MentorController::class, 'getAllMeetings']);
        Route::get('/meetings/{id}/review', [MentorController::class, 'getMeeting']); 
    });


     //Messages
    Route::prefix('message-management')->group(function () {
        Route::post('/messages', [MentorController::class, 'sendMessageToEntrepreneur']);
        Route::get('/messages/{id}', [MentorController::class, 'getEntrepreneurMessages']);
    });
});

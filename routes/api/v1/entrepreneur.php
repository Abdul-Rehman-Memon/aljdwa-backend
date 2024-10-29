<?php

use App\Http\Controllers\Api\v1\EntrepreneurController;
use App\Http\Controllers\Api\v1\AdminController;
use Illuminate\Support\Facades\Route;

use App\Http\Middleware\CheckRole;

Route::middleware(['auth:sanctum', CheckRole::class . ':Entrepreneur'])->prefix('entrepreneur')->group(function () {

    //Entrepreneur Application Request
    Route::prefix('application-management')->group(function () {
        Route::put('/entrepreneur-applications/{id}', [EntrepreneurController::class, 'updateEntrepreneurApplication']);
    });
    //Meetings
    Route::prefix('meeting-management')->group(function () {
        Route::post('/meetings', [EntrepreneurController::class, 'createMeeting']);
        // Route::get('/meetings', [AdminController::class, '']);
        // Route::get('/meetings/{id}/review', [AdminController::class, '']);
        // Route::put('/meetings/{id}', [AdminController::class, '']);
    });

    //Entrepreneur Agreement
    Route::prefix('agreement-management')->group(function () {
        Route::post('/agreements', [EntrepreneurController::class, 'createAgreement']);
    });

    //Mentor Assignment
    Route::prefix('mentor-assignment-management')->group(function () {
        Route::post('/mentor-assignments', [EntrepreneurController::class, 'createMentorAssignement']);
    });
});

<?php

use App\Http\Controllers\Api\v1\EntrepreneurController;
use App\Http\Controllers\Api\v1\AdminController;
use Illuminate\Support\Facades\Route;

use App\Http\Middleware\CheckRole;

Route::middleware(['auth:sanctum', CheckRole::class . ':Entrepreneur'])->prefix('entrepreneur')->group(function () {

    //Entrepreneur Application Request
    Route::prefix('application-management')->group(function () {
        Route::get('/entrepreneur-applications', [EntrepreneurController::class, 'reviewEntrepreneurApplication']);
        Route::put('/entrepreneur-applications/{id}', [EntrepreneurController::class, 'updateEntrepreneurApplication']);
    });
    //Meetings
    Route::prefix('meeting-management')->group(function () {
        Route::post('/meetings', [AdminController::class, 'createMeeting']);
    });

    //Entrepreneur Agreement
    Route::prefix('agreement-management')->group(function () {
        Route::get('/agreements', [EntrepreneurController::class, 'getAgreement']);
        Route::put('/agreements/{id}', [EntrepreneurController::class, 'updateAgreement']);
    });

    //Entrepreneur Payment
    Route::prefix('payment-management')->group(function () {
        Route::post('/payments', [EntrepreneurController::class, 'createPayment']);
    });

    //Mentor Assignment
    Route::prefix('mentor-assignment-management')->group(function () {
        Route::get('/mentor-assignments', [EntrepreneurController::class, 'getAssignedMentorToEntrepreneur']);
    });
});

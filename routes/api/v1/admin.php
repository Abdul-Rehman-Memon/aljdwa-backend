<?php


use App\Http\Controllers\Api\v1\VisitorController;
use App\Http\Controllers\Api\v1\AdminController;
use Illuminate\Support\Facades\Route;

use App\Http\Middleware\CheckRole;

Route::middleware(['auth:sanctum', CheckRole::class . ':Admin'])->prefix('admin')->group(function () {

    //Appointments Schedules
    Route::prefix('appointment-schedule-management')->group(function () {
        Route::post('/appointment-schedules', [AdminController::class, 'createAppointmentSchedule']);
    });
    //Appointments Request
    Route::prefix('appointment-management')->group(function () {
        Route::get('/appointments', [AdminController::class, 'indexAppointments']);
        Route::get('/appointments/{id}/review', [AdminController::class, 'showAppointment']);
        Route::put('/appointments/{id}', [AdminController::class, 'updateAppointment']);
    });
    //Entrepreneur Application Request
    Route::prefix('application-management')->group(function () {
        Route::get('/entrepreneur-applications', [AdminController::class, 'getEntrepreneurApplications']);
        Route::get('/entrepreneur-applications/{id}/review', [AdminController::class, 'reviewEntrepreneurApplication']);
        Route::put('/entrepreneur-applications/{id}', [AdminController::class, 'updateEntrepreneurApplicationStatusByAdmin']);
    });
    //Meetings
    Route::prefix('meeting-management')->group(function () {
        Route::post('/meetings', [AdminController::class, 'createMeeting']);
        // Route::get('/meetings', [AdminController::class, '']);
        // Route::get('/meetings/{id}/review', [AdminController::class, '']);
        // Route::put('/meetings/{id}', [AdminController::class, '']);
    });

    //Entrepreneur Agreement
    Route::prefix('agreement-management')->group(function () {
        Route::post('/agreements', [AdminController::class, 'createAgreement']);
    });

    //Mentor Assignment
    Route::prefix('mentor-assignment-management')->group(function () {
        Route::post('/mentor-assignments', [AdminController::class, 'createMentorAssignement']);
    });
});

Route::prefix('visitor')->group(function () {
    
    Route::prefix('appointment-management')->group(function () {
        Route::post('/request-appointment', [VisitorController::class, 'createAppointment']);
    });

    Route::prefix('appointment-schedule-management')->group(function () {
        Route::get('/appointment-schedules', [VisitorController::class, 'getAppointmentSchedules']);
    });
});

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
    //User Application Request
    Route::prefix('application-management')->group(function () {
        //Entrepreneur
        Route::get('/entrepreneur-applications', [AdminController::class, 'getEntrepreneurApplications']);
        Route::get('/entrepreneur-applications/{id}/review', [AdminController::class, 'reviewEntrepreneurApplication']);
        Route::put('/entrepreneur-applications/{id}', [AdminController::class, 'updateEntrepreneurApplicationStatusByAdmin']);
        //Mentor
        Route::get('/mentor-applications', [AdminController::class, 'getMentorApplications']);
        Route::get('/mentor-applications/{id}/review', [AdminController::class, 'reviewMentorApplication']);
        Route::put('/mentor-applications/{id}', [AdminController::class, 'updateMentorApplicationStatusByAdmin']);
    });

    
    //Meetings
    Route::prefix('meeting-management')->group(function () {
        Route::post('/meetings', [AdminController::class, 'createMeeting']);
        Route::get('/admin-scheduled-meetings', [AdminController::class, 'getAllAdminScheduledMeetings']);
        Route::get('/meetings', [AdminController::class, 'getAllMeetings']);
        Route::get('/meetings/{id}/review', [AdminController::class, 'getMeeting']); 
    });

    //Entrepreneur Agreement
    Route::prefix('agreement-management')->group(function () {
        Route::post('/agreements', [AdminController::class, 'createAgreement']);
        Route::get('/agreements', [AdminController::class, 'getAllAgreements']);
        Route::get('/agreements/{id}/review', [AdminController::class, 'getAgreement']);
    });

    //Mentor Assignment
    Route::prefix('mentor-assignment-management')->group(function () {
        Route::post('/mentor-assignments', [AdminController::class, 'createMentorAssignement']);
        Route::get('/mentor-assignments', [AdminController::class, 'getAllMentorAssignments']);
        Route::get('/mentor-assignments/{id}/review', [AdminController::class, 'MentorAssignment']);
        Route::get('/get-all-mentors-assigned-to-entrepreneur/{user_id}', [AdminController::class, 'MentorAssignmentByUserId']);
    });

    //Entrepreneur Payment
    Route::prefix('payment-management')->group(function () {
        Route::get('/payments', [AdminController::class, 'getAllPayments']);
        Route::get('/payments/{id}/review', [AdminController::class, 'getPayment']);
        // Route::put('/payments/{id}', [AdminController::class, 'updatePayment']);
        Route::post('/payments/{id}', [AdminController::class, 'updatePayment']);
    });

    //Messages
    Route::prefix('message-management')->group(function () {
        Route::post('/messages', [AdminController::class, 'sendMessageToUser']);
        Route::get('/messages/{id}', [AdminController::class, 'getUsersMessages']);
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

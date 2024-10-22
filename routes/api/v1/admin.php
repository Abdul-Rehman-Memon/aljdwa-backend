<?php


use App\Http\Controllers\Api\v1\AppointmentController;
use Illuminate\Support\Facades\Route;

use App\Http\Middleware\CheckRole;

Route::middleware(['auth:sanctum', CheckRole::class . ':Admin'])->prefix('admin')->group(function () {
    Route::get('/get-appointments', [AppointmentController::class, 'getAllappointments']);
    Route::get('/get-single-appointment/{id}', [AppointmentController::class, 'getSingleAppointment']);
    Route::put('/update-appointment/{id}', [AppointmentController::class, 'updateAppointment']);
});

Route::prefix('visitor')->group(function () {
    Route::post('/request-appointment', [AppointmentController::class, 'createAppointment']);
});

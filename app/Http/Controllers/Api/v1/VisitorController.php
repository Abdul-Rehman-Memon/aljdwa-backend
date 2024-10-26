<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\v1\Appointments\AppointmentRequest;
use App\Services\v1\AppointmentService;
use Exception;
use App\Http\Helpers\ResponseHelper;

class VisitorController extends Controller
{
    protected $appointmentService;

    public function __construct(AppointmentService $appointmentService)
    {
        $this->appointmentService = $appointmentService;
    }
    
    public function createAppointment(AppointmentRequest $request)
    {
        $validatedData = $request->validated();

        try {
            $user = $this->appointmentService->createAppointment($validatedData);
            return ResponseHelper::created($user,'Appointment requested successfully');
        } catch (Exception $e) {
            // Handle the error
            return ResponseHelper::error('Failed to request appointment.',500,$e->getMessage());
        }
    }
}

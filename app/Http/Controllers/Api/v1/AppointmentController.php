<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\v1\Appointments\AppointmentRequest;
use App\Http\Requests\v1\Appointments\AppointmentUpdateRequest;
use App\Services\v1\AppointmentService;
use Exception;
use App\Http\Helpers\ResponseHelper;

class AppointmentController extends Controller
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

    public function getSingleAppointment($appointmentId)
    {

        try {
            $appointment = $this->appointmentService->getSingleAppointment($appointmentId);

            if($appointment){
                return ResponseHelper::success($appointment,'Appointment retrieved successfully');
            }else{
                return ResponseHelper::notFound('Appointment not found'); 
            }
            
        } catch (Exception $e) {
            return ResponseHelper::error('Failed to retrieve appointment.', 500, $e->getMessage());
        }
    }

    public function getAllappointments(Request $request)
    {

        $limit = $request->input('limit', 10);
        $offset = $request->input('offset', 0);
    
        try {
            $appointments = $this->appointmentService->getAllAppointments($limit, $offset);
            $data = $appointments['appointments'];
            $totalCount = $appointments['totalCount'];
            $limit = $appointments['limit'];
            $offset = $appointments['offset'];
            $message =  'Appointments retrieved successfully';
            if(count($data) === 0){
                $message =  'Could not find Appointments';
            }
            return ResponseHelper::successWithPagination($data,$totalCount,$limit,$offset,$message);
        } catch (Exception $e) {
            return ResponseHelper::error('Failed to retrieve appointments.', 500, $e->getMessage());
        }
    }

    public function updateAppointment(AppointmentUpdateRequest $request, $appointmentId)
    {

        $validatedData = $request->validated();

        try {
            $appointment = $this->appointmentService->getSingleAppointment($appointmentId);
            if (!$appointment) {
                return ResponseHelper::notFound('Appointment not found');
            }

            $user = $this->appointmentService->updateAppointment($validatedData, $appointmentId);
            return ResponseHelper::success($user,'Appointment updated successfully');

        } catch (Exception $e) {
            // Handle the error
            return ResponseHelper::error('Failed to update appointment.',500,$e->getMessage());
        }
    }
}

<?php

namespace App\Http\Controllers\Api\v1;

use App\helpers\appHelpers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\v1\Appointments\AppointmentRequest;
use App\Services\v1\AppointmentService;
use Exception;
use App\Http\Helpers\ResponseHelper;
use Carbon\Carbon;

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

    public function getAppointmentSchedules(Request $request){

        $data['date'] = $request->input('date') ?? Carbon::now()->startOfDay()->timestamp;
        $data['time'] = $request->input('time') ?? NULL;
        $data['status'] = $request->input('status') ? appHelpers::lookUpId('Active_status',$request->input('status')) : NULL;
        try {
            $availabeSlots = $this->appointmentService->AvailableAppointmentSlots($data);
            $allSlots = $this->appointmentService->AppointmentSchedules($data);
            $result['available_slots'] = $availabeSlots; 
            $result['all_slots'] = $allSlots; 
            return ResponseHelper::success($result,'Appointment schedules slots retrieved successfully');
        } catch (Exception $e) {
            // Handle the error
            return ResponseHelper::error('Failed to retrieve appointment slots.',500,$e->getMessage()."Line no:".$e->getLine());
        }
    }
}

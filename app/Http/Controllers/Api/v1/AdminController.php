<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests\v1\Appointments\AppointmentUpdateRequest;
use App\Http\Requests\v1\Applications\ApplicationRequest;
use App\Http\Requests\v1\Meetings\MeetingRequest;
use App\Http\Requests\v1\Entrepreneur_agreement\EntrepreneurAgreementRequest;

use App\Services\v1\UserService;
use App\Services\v1\AppointmentService;
use App\Services\v1\EntreprenuerDetailsService;
use App\Services\v1\MeetingService;
use App\Services\v1\EntreprenuerAgreementService;

use Exception;
use App\Http\Helpers\ResponseHelper;

class AdminController extends Controller
{
    protected $appointmentService;
    protected $entreprenuerDetailsService;
    protected $meetingsService;
    protected $entreprenuerAgreementService;
    
    public function __construct(
        AppointmentService $appointmentService,
        EntreprenuerDetailsService $entreprenuerDetailsService,
        MeetingService $meetingsService,
        EntreprenuerAgreementService $entreprenuerAgreementService,
        )
    {
        $this->appointmentService = $appointmentService;
        $this->entreprenuerDetailsService = $entreprenuerDetailsService;
        $this->meetingsService = $meetingsService;
        $this->entreprenuerAgreementService = $entreprenuerAgreementService;
        
    }

    /*********** Appointment Request ***********/
    public function indexAppointments(Request $request)
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

    public function showAppointment($appointmentId)
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
    /*********** Entrepreneur Application ***********/
    public function getEntrepreneurApplications(Request $request)
    {

        $limit = $request->input('limit', 10);
        $offset = $request->input('offset', 0);

        try {
            $applications = $this->entreprenuerDetailsService->getEntrepreneurApplications($limit, $offset);
            $data = $applications['entrepreneur_applications'];
            $totalCount = $applications['totalCount'];
            $limit = $applications['limit'];
            $offset = $applications['offset'];
            $message =  'User application requests retrieved successfully';

            if(count($data) === 0){
                return ResponseHelper::notFound('User Application not found'); 
            }else{
                return ResponseHelper::successWithPagination($data,$totalCount,$limit,$offset,$message);
            }
            
        } catch (Exception $e) {
            return ResponseHelper::error('Failed to retrieve application.', 500, $e->getMessage());
        }
    }

    public function reviewEntrepreneurApplication($applicationId)
    {

        try {
            $application = $this->entreprenuerDetailsService->reviewEntrepreneurApplication($applicationId);

            if($application){
                return ResponseHelper::success($application,'Entreprenuer Application retrieved successfully');
            }else{
                return ResponseHelper::notFound('Entreprenuer Application not found'); 
            }
            
        } catch (Exception $e) {
            return ResponseHelper::error('Failed to retrieve application.', 500, $e->getMessage());
        }
    }

    public function updateEntrepreneurApplication(ApplicationRequest $request, $applicationId)
    {

        $validatedData = $request->validated();

        try {
            $application = $this->entreprenuerDetailsService->reviewEntrepreneurApplication($applicationId);
            if (!$application) {
                return ResponseHelper::notFound('Application not found');
            }

            $user = $this->entreprenuerDetailsService->updateEntrepreneurApplication($validatedData, $applicationId);
            return ResponseHelper::success($user,'Application updated successfully');

        } catch (Exception $e) {
            // Handle the error
            return ResponseHelper::error('Failed to update application.',500,$e->getMessage());
        }
    }

    /*********** Meeting ***********/
    public function createMeeting(MeetingRequest $request)
    {
        $validatedData = $request->validated();

        try {
            $user = $this->meetingsService->createMeeting($validatedData);
            return ResponseHelper::created($user,'Meeting scheduled successfully');
        } catch (Exception $e) {
            // Handle the error
            return ResponseHelper::error('Failed to schedule meeting.',500,$e->getMessage());
        }
    }

    /*********** Entrepeneur Agreement ***********/
    public function createAgreement(EntrepreneurAgreementRequest $request)
    {
        $validatedData = $request->validated();

        try {
            $user = $this->entreprenuerAgreementService->createAgreement($validatedData);
            return ResponseHelper::created($user,'Entrepreneur agreement created successfully');
        } catch (Exception $e) {
            // Handle the error
            return ResponseHelper::error('Failed to create entrepreneur agreement.',500,$e->getMessage());
        }
    }

}

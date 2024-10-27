<?php

namespace App\Http\Controllers\Api\v1;

use App\helpers\appHelpers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests\v1\Appointments\AppointmentUpdateRequest;
use App\Http\Requests\v1\Applications\ApplicationRequest;
use App\Http\Requests\v1\Meetings\MeetingRequest;
use App\Http\Requests\v1\Entrepreneur_agreement\EntrepreneurAgreementRequest;
use App\Http\Requests\v1\Mentor_assignment\MentorAssignmentRequest;

use App\Services\v1\UserService;
use App\Services\v1\AppointmentService;
use App\Services\v1\EntreprenuerDetailsService;
use App\Services\v1\MeetingService;
use App\Services\v1\EntreprenuerAgreementService;
use App\Services\v1\MentorsAssignmentService;

use Exception;
use App\Http\Helpers\ResponseHelper;

class AdminController extends Controller
{
    protected $userService;
    protected $appointmentService;
    protected $entreprenuerDetailsService;
    protected $meetingsService;
    protected $entreprenuerAgreementService;
    protected $mentorsAssignmentService;
    
    public function __construct(
        UserService $userService,
        AppointmentService $appointmentService,
        EntreprenuerDetailsService $entreprenuerDetailsService,
        MeetingService $meetingsService,
        EntreprenuerAgreementService $entreprenuerAgreementService,
        MentorsAssignmentService $mentorsAssignmentService,
        )
    {
        $this->userService = $userService;
        $this->appointmentService = $appointmentService;
        $this->entreprenuerDetailsService = $entreprenuerDetailsService;
        $this->meetingsService = $meetingsService;
        $this->entreprenuerAgreementService = $entreprenuerAgreementService;
        $this->mentorsAssignmentService = $mentorsAssignmentService;
        
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

            $validatedData['status'] = appHelpers::lookUpId('Appointment_status',$validatedData['status']);

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
            $validatedData['status'] = appHelpers::lookUpId('Application_status',$validatedData['status']);

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
            $meeting = $this->meetingsService->createMeeting($validatedData);
            return ResponseHelper::created($meeting,'Meeting scheduled successfully');
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
            $agreement = $this->entreprenuerAgreementService->createAgreement($validatedData);
            return ResponseHelper::created($agreement,'Entrepreneur agreement created successfully');
        } catch (Exception $e) {
            // Handle the error
            return ResponseHelper::error('Failed to create entrepreneur agreement.',500,$e->getMessage());
        }
    }

    /*********** Mentor Assignment ***********/
    public function createMentorAssignement(MentorAssignmentRequest $request)
    {
        $validatedData = $request->validated();
        $entrepreneur_details_id = $validatedData['entrepreneur_details_id'];
        $mentor_id = $validatedData['mentor_id'];
        try {
            // $isMentor = appHelpers::lookUpId('status','Pending');
            // return response()->json($isMentor);
            $isMentor = appHelpers::isMentor($mentor_id);
            if(!$isMentor)
            return ResponseHelper::notFound('Invalid Mentor id/Not Mentor role');
            $agreement = $this->entreprenuerAgreementService->getEntrepreneurAgreementWithPayment($entrepreneur_details_id);
            if($agreement['agreement_status'] !== 'Accepted' || $agreement['payment_status'] !== 'Paid')
            return ResponseHelper::error('Agreement not accepted/payment not paid .',400,$agreement);
            $mentor_assignment = $this->mentorsAssignmentService->createMentorAssignment($validatedData);
            return ResponseHelper::created($mentor_assignment,'Mentor assignment created successfully');
        } catch (Exception $e) {
            // Handle the error
            return ResponseHelper::error('Failed to create mentor assignment.',500,$e->getMessage());
        }
    }

}

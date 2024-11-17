<?php

namespace App\Http\Controllers\Api\v1;

use App\helpers\appHelpers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests\v1\Appointments_schedule\AppointmentScheduleRequest;
use App\Http\Requests\v1\Appointments\AppointmentUpdateRequest;
use App\Http\Requests\v1\Applications\ApplicationRequest;
use App\Http\Requests\v1\Meetings\MeetingRequest;
use App\Http\Requests\v1\Entrepreneur_agreement\EntrepreneurAgreementRequest;
use App\Http\Requests\v1\Payments\UpdatePaymentRequest;
use App\Http\Requests\v1\Messages\MessageRequest;

use App\Http\Requests\v1\Mentor_assignment\MentorAssignmentRequest;

use App\Services\v1\UserService;
use App\Services\v1\AppointmentsScheduleService;
use App\Services\v1\AppointmentService;
use App\Services\v1\EntreprenuerDetailsService;
use App\Services\v1\MeetingService;
use App\Services\v1\EntreprenuerAgreementService;
use App\Services\v1\PaymentsService;
use App\Services\v1\MentorsAssignmentService;
use App\Services\v1\MessageService;

use Exception;
use App\Http\Helpers\ResponseHelper;

use Illuminate\Container\Attributes\Auth;

class AdminController extends Controller
{
    protected $userService;
    protected $appointmentsScheduleService;
    protected $appointmentService;
    protected $entreprenuerDetailsService;
    protected $meetingsService;
    protected $entreprenuerAgreementService;
    protected $paymentService;
    protected $mentorsAssignmentService;
    protected $messageService;
    
    public function __construct(
        UserService $userService,
        AppointmentsScheduleService $appointmentsScheduleService,
        AppointmentService $appointmentService,
        EntreprenuerDetailsService $entreprenuerDetailsService,
        MeetingService $meetingsService,
        EntreprenuerAgreementService $entreprenuerAgreementService,
        PaymentsService $paymentService,
        MentorsAssignmentService $mentorsAssignmentService,
        MessageService $messageService,
        )
    {
        $this->userService = $userService;
        $this->appointmentsScheduleService = $appointmentsScheduleService;
        $this->appointmentService = $appointmentService;
        $this->entreprenuerDetailsService = $entreprenuerDetailsService;
        $this->meetingsService = $meetingsService;
        $this->entreprenuerAgreementService = $entreprenuerAgreementService;
        $this->paymentService = $paymentService;
        $this->mentorsAssignmentService = $mentorsAssignmentService;
        $this->messageService = $messageService;
        
    }

    /*********** Appointments Schedule ***********/
    public function createAppointmentSchedule(AppointmentScheduleRequest $request)
    {
        $validatedData = $request->validated();

        try {
            $appointment_schedule = $this->appointmentsScheduleService->createAppointmentSchedule($validatedData);
            return ResponseHelper::created($appointment_schedule,'Appointment schedules created successfully');
        } catch (Exception $e) {
            // Handle the error
            return ResponseHelper::error('Failed to create appointment schedule.',500,$e->getMessage());
        }
    }

    /*********** Appointment Request ***********/
    public function indexAppointments(Request $request)
    {
    
        try {
            $appointments = $this->appointmentService->getAllAppointments($request);
            $data = $appointments['appointments'];
            $totalCount = $appointments['totalCount'];
            $limit = $appointments['limit'];
            $offset = $appointments['offset'];
            $message =  'Appointments retrieved successfully';
            // if(count($data) === 0){
            //     $message =  'Could not find Appointments';
            // }
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
            $applications = $this->entreprenuerDetailsService->getEntrepreneurApplications($request);
            $data = $applications['entrepreneur_applications'];
            $totalCount = $applications['totalCount'];
            $limit = $applications['limit'];
            $offset = $applications['offset'];
            $message =  'User application requests retrieved successfully';

            // if(count($data) === 0){
            //     return ResponseHelper::notFound('User Application not found'); 
            // }
            return ResponseHelper::successWithPagination($data,$totalCount,$limit,$offset,$message);
            
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

    public function updateEntrepreneurApplicationStatusByAdmin(ApplicationRequest $request, $applicationId)
    {

        $validatedData = $request->validated();

        try {
            $application = $this->entreprenuerDetailsService->reviewEntrepreneurApplication($applicationId);
            if (!$application) {
                return ResponseHelper::notFound('Application not found');
            }
            $validatedData['status'] = appHelpers::lookUpId('Application_status',$validatedData['status']);

            $user = $this->userService->updateApplicationStatusByAdmin($validatedData, $applicationId);
            return ResponseHelper::success($user,'Application updated successfully');

        } catch (Exception $e) {
            // Handle the error
            return ResponseHelper::error('Failed to update application.',500,$e->getMessage());
        }
    }

    /*********** Mentor Application ***********/
    public function getMentorApplications(Request $request)
    {

        try {
            $application = $this->userService->getMentorApplications($request);
            $data = $application['users'];
            $totalCount = $application['totalCount'];
            $limit = $application['limit'];
            $offset = $application['offset'];
            $message =  'Mentor users retrieved successfully';

            // if(count($data) === 0){
            //     return ResponseHelper::notFound('Mentor user not found'); 
            // }
            return ResponseHelper::successWithPagination($data,$totalCount,$limit,$offset,$message);
            
        } catch (Exception $e) {
            return ResponseHelper::error('Failed to retrieve mentor users.', 500, $e->getMessage());
        }
    }

    public function reviewMentorApplication($applicationId)
    {
        try {
            $application = $this->userService->reviewMentorApplication($applicationId);

            if($application){
                return ResponseHelper::success($application,'Mentor user retrieved successfully');
            }else{
                return ResponseHelper::notFound('Mentor User not found'); 
            }
            
        } catch (Exception $e) {
            return ResponseHelper::error('Failed to retrieve mentor user.', 500, $e->getMessage());
        }
    }

    public function updateMentorApplicationStatusByAdmin(ApplicationRequest $request, $applicationId)
    {

        $validatedData = $request->validated();

        try {
            $application = $this->userService->reviewMentorApplication($applicationId);
            if (!$application) {
                return ResponseHelper::notFound('Application not found');
            }
            $validatedData['status'] = appHelpers::lookUpId('Application_status',$validatedData['status']);

            $user = $this->userService->updateApplicationStatusByAdmin($validatedData, $applicationId);
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
    public function getAllAdminScheduledMeetings(Request $request)
    {

        try {
            $meetings = $this->meetingsService->getAllAdminScheduledMeetings($request);
            $data = $meetings['meetings'];
            $totalCount = $meetings['totalCount'];
            $limit = $meetings['limit'];
            $offset = $meetings['offset'];
            $message =  'Meetings retrieved successfully';

            // if(count($data) === 0){
            //     return ResponseHelper::notFound('meeting not found'); 
            // }else{
                
            // }

            return ResponseHelper::successWithPagination($data,$totalCount,$limit,$offset,$message);
            
        } catch (Exception $e) {
            return ResponseHelper::error('Failed to retrieve application.', 500, $e->getMessage());
        }
    }

    public function getAllMeetings(Request $request)
    {

        try {
            $meetings = $this->meetingsService->getAllMeetings($request);
            $data = $meetings['meetings'];
            $totalCount = $meetings['totalCount'];
            $limit = $meetings['limit'];
            $offset = $meetings['offset'];
            $message =  'Meetings retrieved successfully';

            // if(count($data) === 0){
            //     return ResponseHelper::notFound('meeting not found'); 
            // }else{
                
            // }

            return ResponseHelper::successWithPagination($data,$totalCount,$limit,$offset,$message);
            
        } catch (Exception $e) {
            return ResponseHelper::error('Failed to retrieve application.', 500, $e->getMessage());
        }
    }

    public function getMeeting($id)
    {
        try {
            $meeting = $this->meetingsService->getMeeting($id);

            if($meeting){
                return ResponseHelper::success($meeting,'meeting retrieved successfully.'); 
            }else{
                return ResponseHelper::notFound('meeting not found'); 
            }
            
        } catch (Exception $e) {
            return ResponseHelper::error('Failed to retrieve application.', 500, $e->getMessage());
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
            return ResponseHelper::error('Failed to create entrepreneur agreement.',500,$e->getMessage()."Line no:".$e->getLine());
        }
    }

    public function getAllAgreements(Request $request)
    {
        try {
            $agreement = $this->entreprenuerAgreementService->getAllAgreements($request);
            $data = $agreement['agreements'];
            $totalCount = $agreement['totalCount'];
            $limit = $agreement['limit'];
            $offset = $agreement['offset'];
            $message =  'Agreements retrieved successfully';

            // if(count($data) === 0){
            //     return ResponseHelper::notFound('agreement not found'); 
            // }else{
                
            // }
            return ResponseHelper::successWithPagination($data,$totalCount,$limit,$offset,$message);
            
        } catch (Exception $e) {
            return ResponseHelper::error('Failed to retrieve agreements.', 500, $e->getMessage());
        }
    }

    public function getAgreement($id)
    {
        try {
            $meeting = $this->entreprenuerAgreementService->getAgreement($id);

            if($meeting){
                return ResponseHelper::success($meeting,'agreement retrieved successfully.'); 
            }else{
                return ResponseHelper::notFound('agreement not found'); 
            }
            
        } catch (Exception $e) {
            return ResponseHelper::error('Failed to retrieve agreement.', 500, $e->getMessage());
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
            $agreementPayment = $this->entreprenuerAgreementService->getEntrepreneurAgreementWithPayment($entrepreneur_details_id);
            if(!$agreementPayment)
            return ResponseHelper::error('Agreement not accepted/payment not paid .',400,$agreementPayment);
            $mentor_assignment = $this->mentorsAssignmentService->createMentorAssignment($validatedData);
            return ResponseHelper::created($mentor_assignment,'Mentor assignment created successfully');
        } catch (Exception $e) {
            // Handle the error
            return ResponseHelper::error('Failed to create mentor assignment.',500,$e->getMessage());
        }
    }

    public function getAllMentorAssignments(Request $request)
    {
        try {
            $result = $this->mentorsAssignmentService->getAllMentorAssignments($request);
            $data = $result['mentor_assignment'];
            $totalCount = $result['totalCount'];
            $limit = $result['limit'];
            $offset = $result['offset'];
            $message =  'Mentor Assignments retrieved successfully';

            // if(count($data) === 0){
            //     return ResponseHelper::notFound('mentor assignment not found'); 
            // }else{
                
            // }
            return ResponseHelper::successWithPagination($data,$totalCount,$limit,$offset,$message);
            
        } catch (Exception $e) {
            return ResponseHelper::error('Failed to retrieve mentor assignments.', 500, $e->getMessage());
        }
    }

    public function MentorAssignment($id)
    {
        try {
            $result = $this->mentorsAssignmentService->MentorAssignment($id);

            if($result){
                return ResponseHelper::success($result,'mentor assignment retrieved successfully.'); 
            }else{
                return ResponseHelper::notFound('mentor assignment not found'); 
            }
            
        } catch (Exception $e) {
            return ResponseHelper::error('Failed to retrieve mentor assignment.', 500, $e->getMessage());
        }
    }

    public function MentorAssignmentByUserId(Request $request, $userId)
    {
        try {
            $user = $this->userService->getUser($userId);
            if (!$user)
                return ResponseHelper::notFound('Invalid User Id'); 

            $result = $this->mentorsAssignmentService->MentorAssignmentByUserId($request,$userId);

            $data = $result['mentor_assignment'];
            $totalCount = $result['totalCount'];
            $limit = $result['limit'];
            $offset = $result['offset'];
            $message =  'Mentor Assignments retrieved successfully';

            // if(count($data) === 0){
            //     return ResponseHelper::notFound('mentor assignment not found'); 
            // }else{
                
            // }
            return ResponseHelper::successWithPagination($data,$totalCount,$limit,$offset,$message);
            
        } catch (Exception $e) {
            return ResponseHelper::error('Failed to retrieve mentor assignments.', 500, $e->getMessage());
        }
    }
     /*********** Payments ***********/
     public function getAllPayments(Request $request)
     {
         try {
             $result = $this->paymentService->getAllPayments($request);
             $data = $result['payments'];
             $totalCount = $result['totalCount'];
             $limit = $result['limit'];
             $offset = $result['offset'];
             $message =  'Payments retrieved successfully';
 
            //  if(count($data) === 0){
            //      return ResponseHelper::notFound('payment not found'); 
            //  }else{
                 
            //  }
            return ResponseHelper::successWithPagination($data,$totalCount,$limit,$offset,$message);
             
         } catch (Exception $e) {
             return ResponseHelper::error('Failed to retrieve payments.', 500, $e->getMessage());
         }
     }
 
    public function getPayment($id)
    {
        try {
            $result = $this->paymentService->getPayment($id);

            if($result){
                return ResponseHelper::success($result,'payments retrieved successfully.'); 
            }else{
                return ResponseHelper::notFound('payment not found'); 
            }
            
        } catch (Exception $e) {
            return ResponseHelper::error('Failed to retrieve payments.', 500, $e->getMessage());
        }
    }

    public function updatePayment(UpdatePaymentRequest $request, $id)
    {
        
        $validatedData = $request->validated();

        try {
            $appointment = $this->paymentService->getPayment($id);
            if (!$appointment) {
                return ResponseHelper::notFound('payment not found');
            }

            $validatedData['status'] = appHelpers::lookUpId('payment_status',$validatedData['status']);

            $user = $this->paymentService->updatePayment($validatedData, $id);
            return ResponseHelper::success($user,'Payment updated successfully');

        } catch (Exception $e) {
            // Handle the error
            return ResponseHelper::error('Failed to update payment.',500,$e->getMessage());
        }
    }

     /*********** Messages ***********/
     public function sendMessageToUser(MessageRequest $request){
        $validatedData = $request->validated();
        try {
            
            $message = $this->messageService->createMessage($validatedData);
            return ResponseHelper::success($message,'Message Sent successfully');
        } catch (Exception $e) {
            // Handle the error
            return ResponseHelper::error('Failed to sent message to mentor.',500,$e->getMessage()."Line no :".$e->getLine());
        }
    }

    public function getUsersMessages($userId){
         try { 
             $message = $this->messageService->getMessage($userId);
             return ResponseHelper::success($message,'Message retrieved successfully');
         } catch (Exception $e) {
             // Handle the error
             return ResponseHelper::error('Failed to retrieve message.',500,$e->getMessage());
         }
     }

}

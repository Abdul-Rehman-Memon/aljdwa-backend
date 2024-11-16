<?php

namespace App\Http\Controllers\Api\v1;

use App\helpers\appHelpers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests\v1\Applications\UpdateApplicationRequest;
use App\Http\Requests\v1\Meetings\MeetingRequest;
use App\Http\Requests\v1\Entrepreneur_agreement\UpdateEntrepreneurAgreementRequest;
use App\Http\Requests\v1\Payments\PaymentRequest;
use App\Http\Requests\v1\Mentor_assignment\MentorAssignmentRequest;
use App\Http\Requests\v1\Messages\MessageRequest;

use App\Services\v1\UserService;
use App\Services\v1\EntreprenuerDetailsService;
use App\Services\v1\MeetingService;
use App\Services\v1\EntreprenuerAgreementService;
use App\Services\v1\PaymentsService;
use App\Services\v1\MentorsAssignmentService;
use App\Services\v1\MessageService;
use Illuminate\Support\Facades\Auth;


use Exception;
use App\Http\Helpers\ResponseHelper;

class EntrepreneurController extends Controller
{
    protected $userService;
    protected $entreprenuerDetailsService;
    protected $meetingsService;
    protected $entreprenuerAgreementService;
    protected $paymentService;
    protected $mentorsAssignmentService;
    protected $messageService;
    
    public function __construct(
        UserService $userService,
        EntreprenuerDetailsService $entreprenuerDetailsService,
        MeetingService $meetingsService,
        EntreprenuerAgreementService $entreprenuerAgreementService,
        PaymentsService $paymentService,
        MentorsAssignmentService $mentorsAssignmentService,
        MessageService $messageService,
        )
    {
        $this->userService = $userService;
        $this->entreprenuerDetailsService = $entreprenuerDetailsService;
        $this->meetingsService = $meetingsService;
        $this->entreprenuerAgreementService = $entreprenuerAgreementService;
        $this->paymentService = $paymentService;
        $this->mentorsAssignmentService = $mentorsAssignmentService;
        $this->messageService = $messageService;
        
    }

    /*********** Entrepreneur Application ***********/
    public function updateEntrepreneurApplication(UpdateApplicationRequest $request, $applicationId)
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

    public function reviewEntrepreneurApplication()
    {
        $applicationId = Auth::user()->id;
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

    /*********** Entrepeneur Agreement ***********/
    public function getAgreement()
    {
        try {
            $agreement = $this->entreprenuerAgreementService->getEntrepreneurAgreement();
            return ResponseHelper::success($agreement,'Entrepreneur agreement retrieved successfully');
        } catch (Exception $e) {
            // Handle the error
            return ResponseHelper::error('Failed to fetch entrepreneur agreement.',500,$e->getMessage());
        }
    }

    public function updateAgreement(UpdateEntrepreneurAgreementRequest $request,$agreementId)
    {
        $validatedData = $request->validated();

        try {
            $agreement= $this->entreprenuerAgreementService->getEntrepreneurAgreement($agreementId);
            if (!$agreement) {
                return ResponseHelper::notFound('Agreement not found');
            }
            $validatedData['status'] = appHelpers::lookUpId('Agreement_status',$validatedData['status']);

            $user = $this->entreprenuerAgreementService->updateEntrepreneurAgreement($validatedData, $agreementId);
            return ResponseHelper::success($user,'Agreement updated successfully');

        } catch (Exception $e) {
            // Handle the error
            return ResponseHelper::error('Failed to update agreement.',500,$e->getMessage());
        }
    }

    /*********** Entrepeneur Payment ***********/
    public function createPayment(PaymentRequest $request)
    {
        $validatedData = $request->validated();

        try {
            $payment = $this->paymentService->createPayment($validatedData);
            return ResponseHelper::created($payment,'Entrepreneur payment created successfully');
        } catch (Exception $e) {
            // Handle the error
            return ResponseHelper::error('Failed to create entrepreneur payment.',500,$e->getMessage());
        }
    }

    public function verifyStripePayment($paymentIntentId)
    {
        try {
            $payment = $this->paymentService->verifyStripePayment($paymentIntentId);
            return ResponseHelper::success($payment,'Stripe payment details retrieved successfully');
        } catch (Exception $e) {
            // Handle the error
            return ResponseHelper::error('Failed to fetch stripe payment details.',500,$e->getMessage());
        }
    }

    public function getEntrepreneurPayment()
    {
        try {
            $payment = $this->paymentService->getEntrepreneurPayment();
            return ResponseHelper::success($payment,'Entrepreneur payment retrieved successfully');
        } catch (Exception $e) {
            // Handle the error
            return ResponseHelper::error('Failed to fetch entrepreneur payment.',500,$e->getMessage());
        }
    }

    /*********** Mentor Assignment ***********/
    public function getAllAssignedMentorToEntrepreneur(){
       
        try {
            $mentor_assignment = $this->mentorsAssignmentService->getAllAssignedMentorToEntrepreneur();
            return ResponseHelper::success($mentor_assignment,'Mentors assignment retrieved successfully');
        } catch (Exception $e) {
            // Handle the error
            return ResponseHelper::error('Failed to fetch mentors assignment.',500,$e->getMessage());
        }
    }

    public function getAssignedMentorToEntrepreneur($id){
       
        try {
            $mentor_assignment = $this->mentorsAssignmentService->getAssignedMentorToEntrepreneur($id);
            return ResponseHelper::success($mentor_assignment,'Mentors assignment retrieved successfully');
        } catch (Exception $e) {
            // Handle the error
            return ResponseHelper::error('Failed to fetch mentors assignment.',500,$e->getMessage());
        }
    }
    
    /*********** Meeting ***********/
    public function createMeeting(MeetingRequest $request){
        
        $userId = Auth::user()->id;
        $validatedData = $request->validated();
        try {
            $mentor_assigned = appHelpers::isMentorAssigned($userId,$validatedData['participant_id']);
            if(!$mentor_assigned)
            return ResponseHelper::error('This mentor is not assigned to you.');
            $meeting = $this->meetingsService->createMeeting($validatedData);
            return ResponseHelper::created($meeting,'Meeting scheduled successfully');
        } catch (Exception $e) {
            // Handle the error
            return ResponseHelper::error('Failed to schedule meeting.',500,$e->getMessage());
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

            if(count($data) === 0){
                return ResponseHelper::notFound('meeting not found'); 
            }else{
                return ResponseHelper::successWithPagination($data,$totalCount,$limit,$offset,$message);
            }
            
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

    /*********** Messages ***********/
    public function sendMessageToMentor(MessageRequest $request){
        $userId = Auth::user()->id;
        $validatedData = $request->validated();
        try {
            $mentor_assigned = appHelpers::isMentorAssigned($userId,$validatedData['receiver_id']);
            if(!$mentor_assigned)
            return ResponseHelper::error('This mentor is not assigned to you.');
            
            $message = $this->messageService->createMessage($validatedData);
            return ResponseHelper::success($message,'Message Sent successfully');
        } catch (Exception $e) {
            // Handle the error
            return ResponseHelper::error('Failed to sent message to mentor.',500,$e->getMessage()."Line no :".$e->getLine());
        }
    }

    public function getMentorMessages($mentorId){
       $userId = Auth::user()->id;
        try {
            $mentor_assigned = appHelpers::isMentorAssigned($userId,$mentorId);
            if(!$mentor_assigned)
            return ResponseHelper::error('This mentor is not assigned to you.');

            $message = $this->messageService->getMessage($mentorId);
            return ResponseHelper::success($message,'Message retrieved successfully');
        } catch (Exception $e) {
            // Handle the error
            return ResponseHelper::error('Failed to retrieve message.',500,$e->getMessage());
        }
    }

}

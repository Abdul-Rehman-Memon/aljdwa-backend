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

class MentorController extends Controller
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

    /*********** Mentor Assignment ***********/
    public function getAllEntrepreneurAssignedToMentor(){
       
        try {
            $entrepreneur = $this->mentorsAssignmentService->getAllEntrepreneurAssignedToMentor();
            return ResponseHelper::success($entrepreneur,'Entrepreneurs retrieved successfully');
        } catch (Exception $e) {
            // Handle the error
            return ResponseHelper::error('Failed to fetch Entrepreneurs assiged to you.',500,$e->getMessage());
        }
    }

    public function getEntrepreneurAssignedToMentor($id){
       
        try {
            $entrepreneur = $this->mentorsAssignmentService->getEntrepreneurAssignedToMentor($id);
            return ResponseHelper::success($entrepreneur,'Entrepreneur retrieved successfully');
        } catch (Exception $e) {
            // Handle the error
            return ResponseHelper::error('Failed to fetch Entrepreneur assiged to you.',500,$e->getMessage());
        }
    }

    /*********** Meeting ***********/
    public function createMeeting(MeetingRequest $request){
        
        $userId = Auth::user()->id;
        $validatedData = $request->validated();
        try {
            $mentor_assigned = appHelpers::isMentorAssigned($validatedData['participant_id'],$userId,);
            if(!$mentor_assigned)
            return ResponseHelper::error('You are not assigned to this entrepreneur.');
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
            $data = $this->meetingsService->getAllMeetings($request);
            return ResponseHelper::successWithPagination($data);
            
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
    public function sendMessageToEntrepreneur(MessageRequest $request){
       
        $userId = Auth::user()->id;
        $validatedData = $request->validated();
        try {

            $is_admin = appHelpers::isAdmin($validatedData['receiver_id']);
            if(!$is_admin){
                $mentor_assigned = appHelpers::isMentorAssigned($validatedData['receiver_id'],$userId);
                if(!$mentor_assigned)
                return ResponseHelper::error('You are not assigned to this entrepreneur.');
            }
            
            $message = $this->messageService->createMessage($validatedData);
            return ResponseHelper::success($message,'Message Sent successfully');
        } catch (Exception $e) {
            // Handle the error
            return ResponseHelper::error('Failed to sent message to mentor.',500,$e->getMessage());
        }
    }

    public function getEntrepreneurMessages($entrepreneurId){
       
        $userId = Auth::user()->id;
        try {
            $is_admin = appHelpers::isAdmin($entrepreneurId);
            if(!$is_admin){
                $mentor_assigned = appHelpers::isMentorAssigned($entrepreneurId,$userId);
                if(!$mentor_assigned)
                return ResponseHelper::error('You are not assigned to this entrepreneur.');
            }
            
            $message = $this->messageService->getMessage($entrepreneurId);
            return ResponseHelper::success($message,'Message retrieved successfully');
        } catch (Exception $e) {
            // Handle the error
            return ResponseHelper::error('Failed to retrieve message.',500,$e->getMessage());
        }
    }

}

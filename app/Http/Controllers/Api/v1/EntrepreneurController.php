<?php

namespace App\Http\Controllers\Api\v1;

use App\helpers\appHelpers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests\v1\Applications\UpdateApplicationRequest;
use App\Http\Requests\v1\Meetings\MeetingRequest;
use App\Http\Requests\v1\Entrepreneur_agreement\EntrepreneurAgreementRequest;
use App\Http\Requests\v1\Mentor_assignment\MentorAssignmentRequest;

use App\Services\v1\UserService;
use App\Services\v1\EntreprenuerDetailsService;
use App\Services\v1\MeetingService;
use App\Services\v1\EntreprenuerAgreementService;
use App\Services\v1\MentorsAssignmentService;

use Exception;
use App\Http\Helpers\ResponseHelper;

class EntrepreneurController extends Controller
{
    protected $userService;
    protected $entreprenuerDetailsService;
    protected $meetingsService;
    protected $entreprenuerAgreementService;
    protected $mentorsAssignmentService;
    
    public function __construct(
        UserService $userService,
        EntreprenuerDetailsService $entreprenuerDetailsService,
        MeetingService $meetingsService,
        EntreprenuerAgreementService $entreprenuerAgreementService,
        MentorsAssignmentService $mentorsAssignmentService,
        )
    {
        $this->userService = $userService;
        $this->entreprenuerDetailsService = $entreprenuerDetailsService;
        $this->meetingsService = $meetingsService;
        $this->entreprenuerAgreementService = $entreprenuerAgreementService;
        $this->mentorsAssignmentService = $mentorsAssignmentService;
        
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

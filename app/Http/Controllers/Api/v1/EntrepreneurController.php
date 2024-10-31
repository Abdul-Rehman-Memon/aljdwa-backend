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

use App\Services\v1\UserService;
use App\Services\v1\EntreprenuerDetailsService;
use App\Services\v1\MeetingService;
use App\Services\v1\EntreprenuerAgreementService;
use App\Services\v1\PaymentsService;
use App\Services\v1\MentorsAssignmentService;
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
    
    public function __construct(
        UserService $userService,
        EntreprenuerDetailsService $entreprenuerDetailsService,
        MeetingService $meetingsService,
        EntreprenuerAgreementService $entreprenuerAgreementService,
        PaymentsService $paymentService,
        MentorsAssignmentService $mentorsAssignmentService,
        )
    {
        $this->userService = $userService;
        $this->entreprenuerDetailsService = $entreprenuerDetailsService;
        $this->meetingsService = $meetingsService;
        $this->entreprenuerAgreementService = $entreprenuerAgreementService;
        $this->paymentService = $paymentService;
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

    /*********** Meeting ***********/


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
            $validatedData['status'] = appHelpers::lookUpId('Payment_status',$validatedData['status']);
            $payment = $this->paymentService->createPayment($validatedData);
            return ResponseHelper::created($payment,'Entrepreneur payment created successfully');
        } catch (Exception $e) {
            // Handle the error
            return ResponseHelper::error('Failed to create entrepreneur payment.',500,$e->getMessage());
        }
    }

    /*********** Mentor Assignment ***********/
    public function getAssignedMentorToEntrepreneur(){
       
        try {
            $mentor_assignment = $this->mentorsAssignmentService->getAssignedMentorToEntrepreneur();
            return ResponseHelper::success($mentor_assignment,'Mentors assignment retrieved successfully');
        } catch (Exception $e) {
            // Handle the error
            return ResponseHelper::error('Failed to fetch mentors assignment.',500,$e->getMessage());
        }
    }

}

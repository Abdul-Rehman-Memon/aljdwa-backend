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

class MentorController extends Controller
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

    /*********** Assigned Entrepreneurs ***********/
    public function getEntrepreneurAssignedToMentor(){
       
        try {
            $entrepreneur = $this->mentorsAssignmentService->getEntrepreneurAssignedToMentor();
            return ResponseHelper::success($entrepreneur,'Entrepreneur retrieved successfully');
        } catch (Exception $e) {
            // Handle the error
            return ResponseHelper::error('Failed to fetch Entrepreneur assiged to you.',500,$e->getMessage());
        }
    }

    /*********** Meeting ***********/

}

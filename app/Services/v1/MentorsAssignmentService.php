<?php
namespace App\Services\v1;

use App\Repositories\v1\Mentors_assignment\MentorsAssignmentInterface;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
class MentorsAssignmentService
{
    protected $mentorsAssignmentRepository;

    public function __construct(MentorsAssignmentInterface $mentorsAssignmentRepository)
    {
        $this->mentorsAssignmentRepository = $mentorsAssignmentRepository;
    }

    public function createMentorAssignment(array $data)
    {
        $appointment = $this->mentorsAssignmentRepository->createMentorAssignment($data);

        return $appointment;
    }

}

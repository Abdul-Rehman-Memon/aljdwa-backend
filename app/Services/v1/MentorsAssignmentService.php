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
        $mentor_assignment = $this->mentorsAssignmentRepository->createMentorAssignment($data);

        return $mentor_assignment;
    }

    public function getAssignedMentorToEntrepreneur($id = null)
    {
        $mentor_assignment = $this->mentorsAssignmentRepository->getAssignedMentorToEntrepreneur($id);

        return $mentor_assignment;
    }

    public function getEntrepreneurAssignedToMentor(){

        return $this->mentorsAssignmentRepository->getEntrepreneurAssignedToMentor();
    }

}

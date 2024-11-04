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

    public function getAllAssignedMentorToEntrepreneur()
    {
        $mentor_assignment = $this->mentorsAssignmentRepository->getAllAssignedMentorToEntrepreneur();

        return $mentor_assignment;
    }

    public function getAssignedMentorToEntrepreneur(int $id)
    {
        $mentor_assignment = $this->mentorsAssignmentRepository->getAssignedMentorToEntrepreneur($id);

        return $mentor_assignment;
    }

    public function getAllEntrepreneurAssignedToMentor(){

        return $this->mentorsAssignmentRepository->getAllEntrepreneurAssignedToMentor();
    }

    public function getEntrepreneurAssignedToMentor(int $id){

        return $this->mentorsAssignmentRepository->getEntrepreneurAssignedToMentor($id);
    }

}

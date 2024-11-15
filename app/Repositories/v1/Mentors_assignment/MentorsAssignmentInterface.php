<?php

namespace App\Repositories\v1\Mentors_assignment;

interface MentorsAssignmentInterface
{
    public function createMentorAssignment(array $data);
    public function getAllAssignedMentorToEntrepreneur();
    public function getAssignedMentorToEntrepreneur(int $id);
    public function getAllEntrepreneurAssignedToMentor();
    public function getEntrepreneurAssignedToMentor(int $id);
    public function getAllMentorAssignments(object $data);
    public function MentorAssignment(int $id);
    public function MentorAssignmentByUserId(object $data,string $userId);
}

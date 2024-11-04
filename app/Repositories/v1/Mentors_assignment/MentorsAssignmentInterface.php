<?php

namespace App\Repositories\v1\Mentors_assignment;

interface MentorsAssignmentInterface
{
    public function createMentorAssignment(array $data);
    public function getAllAssignedMentorToEntrepreneur();
    public function getAssignedMentorToEntrepreneur(int $id);
    public function getAllEntrepreneurAssignedToMentor();
    public function getEntrepreneurAssignedToMentor(int $id);
}

<?php

namespace App\Repositories\v1\Mentors_assignment;

interface MentorsAssignmentInterface
{
    public function createMentorAssignment(array $data);
    public function getAssignedMentorToEntrepreneur(int $id = null);
    public function getEntrepreneurAssignedToMentor();
}

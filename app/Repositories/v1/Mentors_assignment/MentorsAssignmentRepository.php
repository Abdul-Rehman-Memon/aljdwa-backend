<?php

namespace App\Repositories\v1\Mentors_assignment;

use App\Models\MentorsAssignment;
use Carbon\Carbon;

class MentorsAssignmentRepository implements MentorsAssignmentInterface
{
    public function createMentorAssignment(array $data)
    {
        return MentorsAssignment::create($data);
    }
}

<?php

namespace App\Repositories\v1\Mentors_assignemnt;

use App\Models\MentorsAssignment;
use Carbon\Carbon;

class MentorsAssignmentRepository implements MentorsAssignmentInterface
{
    public function createMentorAssignment(array $data)
    {
        $timestamp = time();  // Current Unix timestamp
        $data['request_date_time'] = Carbon::createFromTimestamp($timestamp)->toDateTimeString();

        return MentorsAssignment::create($data);
    }
}

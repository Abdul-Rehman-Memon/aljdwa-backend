<?php

namespace App\Repositories\v1\Mentors_assignment;

use App\Models\MentorsAssignment;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class MentorsAssignmentRepository implements MentorsAssignmentInterface
{
    public function createMentorAssignment(array $data)
    {
        return MentorsAssignment::create($data);
    }

    public function getAssignedMentorToEntrepreneur(int $id = null)
    {
        $userId = Auth::user()->id;

        return MentorsAssignment::with([
            'mentor_assign_status',
            'mentor_details',
            'mentor_details.user_role',
            'entrepreneur_details'
            ])
            ->whereHas('entrepreneur_details', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->first();

    }

    public function getEntrepreneurAssignedToMentor()
    {
        // return User::find($userId)->load('user_role');
    }
}

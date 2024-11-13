<?php

namespace App\Repositories\v1\Mentors_assignment;

use App\helpers\appHelpers;
use App\Models\EntrepreneurDetail;
use App\Models\MentorsAssignment;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Mail;
use App\Mail\MentorAssignedNotification;
use App\Mail\EntrepreneurAssignedNotification;

class MentorsAssignmentRepository implements MentorsAssignmentInterface
{
    /*********** Admin Section ***********/
    public function createMentorAssignment(array $data)
    {
        $entrepreneur = EntrepreneurDetail::with('user')->find($data['entrepreneur_details_id']);
        $mentor = User::find($data['mentor_id']);
        $assignment = MentorsAssignment::create($data);
          // Notify both users
        if ($entrepreneur && $mentor) {
            $entrepreneurName = $entrepreneur->user->founder_name; // Assuming there's a user relation
            $mentorName = $mentor->founder_name;
            // Send emails
            // Mail::to($mentor->email)->send(new MentorAssignedNotification($entrepreneurName, $mentorName));
            // Mail::to($entrepreneur->user->email)->send(new EntrepreneurAssignedNotification($entrepreneurName, $mentorName));
            
        }
        return $assignment;
    }
    
    public function getAllMentorAssignments(object $data = null)
    {

        $limit = $data['limit'] ?? 10;
        $offset = $data['offset'] ?? 0;
        $status = $data['status'] ? appHelpers::lookUpId('Active_status',$data['status']) : 0;

        $totalCount = MentorsAssignment::has('entrepreneur_details')->count();

        $result = MentorsAssignment::with([
            'mentor_assign_status',
            'entrepreneur_details',
            'entrepreneur_details.user',
            'mentor_details'
            ])
        ->limit($limit)
        ->offset($offset);

        if($status){
            $result = $result->where('mentors_assignment.status',$status);
        }  

        $result = $result->get();

        return [
            'totalCount' => $totalCount,
            'limit' => $limit,
            'offset' => $offset,
            'mentor_assignment' => $result
        ];        
    }

    public function MentorAssignment(int $id)
    {
        return MentorsAssignment::with([
            'mentor_assign_status',
            'entrepreneur_details',
            'entrepreneur_details.user',
            'mentor_details'
            ])
        ->where('id',$id)
        ->first();         
    }

    /*********** Entrepreneur Section ***********/
    public function getAllAssignedMentorToEntrepreneur()
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
            ->get();
    }

    public function getAssignedMentorToEntrepreneur(int $id)
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
            ->where('mentors_assignment.id',$id)
            ->first();

    }

    /*********** Mentor Section ***********/
    public function getAllEntrepreneurAssignedToMentor()
    {
        $userId = Auth::user()->id;

        return MentorsAssignment::with([
            'mentor_assign_status',
            'entrepreneur_details',
            'entrepreneur_details.user',
            // 'mentor_details'
            ])
            ->where('mentor_id', $userId)
            ->get();
    }

    public function getEntrepreneurAssignedToMentor(int $id)
    {
        $userId = Auth::user()->id;

        return MentorsAssignment::with([
            'mentor_assign_status',
            'entrepreneur_details',
            'entrepreneur_details.user',
            // 'mentor_details'
            ])
            ->where('mentor_id', $userId)
            ->where('mentors_assignment.id',$id)
            ->first();
    }
 
}

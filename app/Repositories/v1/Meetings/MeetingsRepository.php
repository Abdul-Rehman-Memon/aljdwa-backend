<?php

namespace App\Repositories\v1\Meetings;

use App\helpers\appHelpers;
use App\Models\Meeting;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Mail;
use App\Mail\MeetingScheduledByAdmin;
use App\Mail\MeetingScheduled;
use App\Mail\AdminMeetingNotification;

class MeetingsRepository implements MeetingsInterface
{
    public function createMeeting(array $data)
    {
        $userId = Auth::id();
        $user   = User::with('user_role')->where('id',$userId)->first();

        $userRole = $user->user_role->value;
        $data['initiator_id'] = $userId;
        $meeting =  Meeting::create($data);

        $meeting = $meeting->load('meeting_status');


        $participant = User::find($meeting['participant_id']);

        // Meeting details to pass to email
        $meetingDetails = [
            'senderName'   => $user->founder_name,
            'receiverName' => $participant->founder_name,
            'link' => $meeting['link'],
            'meetingPassword' => $meeting['meeting_password'] ?? null,
            'agenda' => $meeting['agenda'],
            'meetingDateTime' => Carbon::parse($meeting['meeting_date_time'])->format('d M Y, h:i A'),
            'status' => 'Scheduled', // Or other status as per logic
            'senderRole' => $userRole, 
            'receiverRole' => $participant->user_role->value,
        ];

        if ($userRole === 'admin') {  
            // Send email to the participant
            // Mail::to($participant->email)
            //     ->send(new MeetingScheduledByAdmin(
            //         $meetingDetails['senderName'],
            //         $meetingDetails['receiverName'],
            //         $meetingDetails['link'],
            //         $meetingDetails['meetingPassword'],
            //         $meetingDetails['agenda'],
            //         $meetingDetails['meetingDateTime'],
            //         $meetingDetails['status']
            //     ));
        }
        else{
            
            // Mail::to($participant->email)
            // ->send(new MeetingScheduled(
            //     $meetingDetails['senderName'],
            //     $meetingDetails['receiverName'],
            //     $meetingDetails['link'],
            //     $meetingDetails['meetingPassword'],
            //     $meetingDetails['agenda'],
            //     $meetingDetails['meetingDateTime'],
            //     $meetingDetails['status']
            // ));

            // $adminEmail = config('mail.admin_email');
            // Mail::to($adminEmail)
            // ->send(new AdminMeetingNotification(
            //     $meetingDetails['senderName'],
            //     $meetingDetails['receiverName'],
            //     $meetingDetails['senderRole'],
            //     $meetingDetails['receiverRole'],
            //     $meetingDetails['link'],
            //     $meetingDetails['meetingPassword'],
            //     $meetingDetails['agenda'],
            //     $meetingDetails['meetingDateTime'],
            //     $meetingDetails['status'], 
            // ));             
        }

        return $meeting; 
    }

    public function getAllAdminScheduledMeetings(object $data)
    {

        $limit    = $data->input('limit', 10);
        $offset   = $data->input('offset', 0);
        $status   = $data->input('status')   ? appHelpers::lookUpId('Meeting_status',$data->input('status'))   : NULL;
        $fromDate = $data->input('fromDate') ? Carbon::createFromTimestamp($data->input('fromDate'))->startOfDay() : NULL;
        $toDate   = $data->input('toDate')   ? Carbon::createFromTimestamp($data->input('toDate'))->endOfDay()     : NULL;

        $userId = Auth::id();
        $totalCount = Meeting::query();

        $meetings = Meeting::with([
            'initiator',
            'participant',
            'meeting_status',
        ])
        ->where('initiator_id',$userId);


        if ($status) {
            $meetings = $meetings->where('meetings.status',$status);
            $totalCount = $totalCount->where('meetings.status',$status);
        }
        
        if ($fromDate || $toDate) {

            if ($fromDate) {
                $meetings = $meetings->where('created_at', '>=', $fromDate);
                $totalCount = $totalCount->where('meetings.created_at', '>=', $fromDate);
            }
            if ($toDate) {
                $meetings = $meetings->where('created_at', '<=', $toDate);
                $totalCount = $totalCount->where('meetings.created_at', '<=', $toDate);
            }
        }
        $meetings = $meetings->orderBy('created_at','desc')
        ->limit($limit)
        ->offset($offset)
        ->get();

        $totalCount = $totalCount->count();

        return [
            'totalCount' => $totalCount,
            'limit' => $limit,
            'offset' => $offset,
            'meetings' => $meetings
        ];    
    }

    public function getAllMeetings(object $data)
    {
        $limit    = $data->input('limit', 10);
        $offset   = $data->input('offset', 0);
        $status   = $data->input('status')   ? appHelpers::lookUpId('Meeting_status',$data->input('status'))   : NULL;
        $fromDate = $data->input('fromDate') ? Carbon::createFromTimestamp($data->input('fromDate'))->startOfDay() : NULL;
        $toDate   = $data->input('toDate')   ? Carbon::createFromTimestamp($data->input('toDate'))->endOfDay()     : NULL;

        $userId = Auth::id();
        $role = appHelpers::getUserRole($userId);

        $query = Meeting::with([
            'initiator',
            'participant',
            'meeting_status',
        ]);
        
        if ($role === 'admin') {
            $query->where(function ($q) use ($userId) {
                $q->where('initiator_id','!=', $userId)
                ->Where('participant_id','!=', $userId);
            });
        }
        else {
            $query->where(function ($q) use ($userId) {
                $q->where('initiator_id', $userId)
                ->orWhere('participant_id', $userId);
            });
        }

        if ($status) {
            $query->where('meetings.status',$status);
        }
        
        if ($fromDate || $toDate) {

            if ($fromDate) {
                $query->where('created_at', '>=', $fromDate);
            }
            if ($toDate) {
                $query->where('created_at', '<=', $toDate);
            }
        }
        $meetings = $query->orderBy('created_at','desc')
        ->limit($limit)
        ->offset($offset)
        ->get();

        $totalCount = $query->count();

        return [
            'totalCount' => $totalCount,
            'limit' => $limit,
            'offset' => $offset,
            'meetings' => $meetings
        ];    
    }

    public function getMeeting(int $id)
    {
        $userId = Auth::id();
        $role = appHelpers::getUserRole($userId);
        
        $query = Meeting::with([
            'initiator',
            'participant',
            'meeting_status',
        ]);
       // Apply the condition if the role is not 'admin'
        if ($role !== 'admin') {
            $query->where(function ($q) use ($userId) {
                $q->where('initiator_id', $userId)
                ->orWhere('participant_id', $userId);
            });
        }

        return $query->where('id',$id)
        ->first();
    }
}

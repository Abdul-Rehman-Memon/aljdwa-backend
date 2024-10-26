<?php

namespace App\Repositories\v1\Meetings;

use App\Models\Meeting;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;


class MeetingsRepository implements MeetingsInterface
{
    public function createMeeting(array $data)
    {
        $data['initiator_id'] = Auth::user()->id;
        $meeting =  Meeting::create($data);

        return $meeting->load('meeting_status');
    }
}

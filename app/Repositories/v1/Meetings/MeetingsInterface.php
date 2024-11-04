<?php

namespace App\Repositories\v1\Meetings;

interface MeetingsInterface
{
    public function createMeeting(array $data);
    public function getAllAdminScheduledMeetings($limit, $offset);
    public function getAllMeetings($limit, $offset);
    public function getMeeting(int $id);
}

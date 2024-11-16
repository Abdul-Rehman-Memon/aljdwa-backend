<?php

namespace App\Repositories\v1\Meetings;

interface MeetingsInterface
{
    public function createMeeting(array $data);
    public function getAllAdminScheduledMeetings(object $data);
    public function getAllMeetings(object $data);
    public function getMeeting(int $id);
}

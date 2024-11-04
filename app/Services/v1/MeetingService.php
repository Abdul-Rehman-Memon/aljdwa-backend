<?php
namespace App\Services\v1;

use App\Repositories\v1\Meetings\MeetingsInterface;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
class MeetingService
{
    protected $meetingRepository;

    public function __construct(MeetingsInterface $meetingRepository)
    {
        $this->meetingRepository = $meetingRepository;
    }

    public function createMeeting(array $data)
    {
        $meeting = $this->meetingRepository->createMeeting($data);

        return $meeting;
    }

    public function getAllAdminScheduledMeetings($limit, $offset)
    {
        $meeting = $this->meetingRepository->getAllAdminScheduledMeetings($limit, $offset);

        return $meeting;
    }

    public function getAllMeetings($limit, $offset)
    {
        $meeting = $this->meetingRepository->getAllMeetings($limit, $offset);

        return $meeting;
    }

    public function getMeeting($id)
    {
        $meeting = $this->meetingRepository->getMeeting($id);

        return $meeting;
    }
}

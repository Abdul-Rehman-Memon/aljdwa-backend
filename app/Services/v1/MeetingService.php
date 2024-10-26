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
        $appointment = $this->meetingRepository->createMeeting($data);

        return $appointment;
    }
}

<?php
namespace App\Services\v1;

use App\Repositories\v1\Appointments_schedule\AppointmentsScheduleInterface;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
class AppointmentsScheduleService
{
    protected $appointmentsScheduleRepository;

    public function __construct(AppointmentsScheduleInterface $appointmentsScheduleRepository)
    {
        $this->appointmentsScheduleRepository = $appointmentsScheduleRepository;
    }

    public function createAppointmentSchedule(array $data)
    {
        $appointment_schedule = $this->appointmentsScheduleRepository->createAppointmentSchedule($data);

        return $appointment_schedule;
    }

    // public function AppointmentSchedules($data)
    // {
    //     $appointment_schedule = $this->appointmentsScheduleRepository->AppointmentSchedules($data);

    //     return $appointment_schedule;
    // }

    // public function AvailableAppointmentSlots($data)
    // {
    //     $appointment_schedule = $this->appointmentsScheduleRepository->AvailableAppointmentSlots($data);

    //     return $appointment_schedule;
    // }

}

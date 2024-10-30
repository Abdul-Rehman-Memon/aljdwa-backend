<?php

namespace App\Repositories\v1\Appointments_schedule;

interface AppointmentsScheduleInterface
{
    public function createAppointmentSchedule(array $data);
    public function AppointmentSchedules(array $data);
    public function AvailableAppointmentSlots(array $data);
}

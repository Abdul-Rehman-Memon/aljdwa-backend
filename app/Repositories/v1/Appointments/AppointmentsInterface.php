<?php

namespace App\Repositories\v1\Appointments;

interface AppointmentsInterface
{
    public function createAppointment(array $data);
    public function getAllAppointments($limit, $offset);
    public function getSingleAppointment(int $appointmentId );
    public function updateAppointment(array $data, int $appointmentId);
    public function AppointmentSchedules(array $data);
    public function AvailableAppointmentSlots(array $data);
}

<?php

namespace App\Repositories\v1\Appointments;

interface AppointmentsInterface
{
    public function createAppointment(array $data);
    public function getAppointments(int $appointmentId = null);
    public function updateAppointment(int $appointmentId, array $data);
}

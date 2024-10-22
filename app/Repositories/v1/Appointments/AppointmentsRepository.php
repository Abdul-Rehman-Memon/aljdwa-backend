<?php

namespace App\Repositories\v1\Appointments;

use App\Models\Appointment;
use Carbon\Carbon;

class AppointmentsRepository implements AppointmentsInterface
{
    public function createAppointment(array $data)
    {
        $timestamp = time();  // Current Unix timestamp
        $data['request_date_time'] = Carbon::createFromTimestamp($timestamp)->toDateTimeString();
        return Appointment::create($data);
    }

    public function getAppointments(int $appointmentId = null)
    {
        // return Appointment::create($data);
    }

    public function updateAppointment(int $appointmentId, array $data)
    {
        // return Appointment::create($data);
    }
}

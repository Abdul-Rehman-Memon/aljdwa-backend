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

        // Disable timestamps for this model
        // Appointment::unsetEventDispatcher();
        return Appointment::create($data);

        // Re-enable event dispatcher if needed later in the application
            // Appointment::setEventDispatcher(app('events'));
    }

    public function getAllAppointments($limit, $offset)
    {
        $totalCount = Appointment::count();

        // Fetch the appointments with the linked status and apply pagination
        $appointments = Appointment::with('appointment_status')
            ->limit($limit)
            ->offset($offset)
            ->get();

        return [
            'totalCount' => $totalCount,
            'limit' => $limit,
            'offset' => $offset,
            'appointments' => $appointments
        ];    
    }

    public function getSingleAppointment(int $appointmentId)
    {
        return Appointment::with('appointment_status')
               ->where('id',$appointmentId)->first();
    }

    public function updateAppointment(array $data, int $appointmentId)
    {
        // $data['approved_by'] = Auth::
        $appointment = Appointment::find($appointmentId);
        
        $appointment->update($data);

        return $appointment;
        
    }
}

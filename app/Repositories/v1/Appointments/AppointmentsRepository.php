<?php

namespace App\Repositories\v1\Appointments;

use App\Models\Appointment;
use App\Models\AppointmentSchedule;
use Carbon\Carbon;
use DB;
class AppointmentsRepository implements AppointmentsInterface
{
    public function createAppointment(array $data)
    {
        // $timestamp = time();  // Current Unix timestamp
        // $data['request_date'] = Carbon::createFromTimestamp($timestamp)->toDateTimeString();

        // Disable timestamps for this model
        // Appointment::unsetEventDispatcher();
        // return $data;
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

    public function AppointmentSchedules($id = null)
    {
        return AppointmentSchedule::get();

    }

    public function AvailableAppointmentSlots(array $data)
    {
        $date = $data['date'];
        $dateFormat = Carbon::createFromTimestamp($date);
        $weekday = Carbon::parse($dateFormat)->dayOfWeek; // Returns 0 (Sunday) to 6 (Saturday)
        $time = $data['time'];

        // return $dateFormat;
        $availableSlotsQuery = AppointmentSchedule::query();
        if ($time) {
            $availableSlotsQuery->where('time', $time);
        }

        $availableSlots = $availableSlotsQuery->whereNotIn('time', function ($query) use ($date) {
            $query->select('request_time')
                  ->from('appointments')
                  ->where('request_date', $date) // Only exclude if `request_date` matches the given `$date`
                  ->whereIn('status', function ($statusQuery) {
                      $statusQuery->select('id')
                                  ->from('lookup_details')
                                  ->where('value', '!=', 'cancelled');
                                  // Add more exclusions if needed
                  });
        })->get();

        return  $availableSlots->isEmpty() ? null : $availableSlots;
    }
}

<?php

namespace App\Repositories\v1\Appointments_schedule;

use App\Models\Appointment;
use App\Models\AppointmentSchedule;
use Carbon\Carbon;
use DB;
use Illuminate\Support\Facades\Auth;

class AppointmentsScheduleRepository implements AppointmentsScheduleInterface
{
    public function createAppointmentSchedule(array $data)
    {
        $userId = Auth::user()->id;
        $data['added_by'] = $userId;
        return AppointmentSchedule::create($data);
    }

    public function AppointmentSchedules(array $data)
    {
        $date = $data['date'];
        $dateFormat = Carbon::createFromTimestamp($date);
        $weekday = Carbon::parse($dateFormat)->dayOfWeek;

        return AppointmentSchedule::where('weekday', $weekday)->get();

    }

    public function AvailableAppointmentSlots(array $data)
    {
        $date = $data['date'];
        $dateFormat = Carbon::createFromTimestamp($date);
        $weekday = Carbon::parse($dateFormat)->dayOfWeek; // Returns 0 (Sunday) to 6 (Saturday)
        $time = $data['time'];

        // return $dateFormat;
        // $availableSlotsQuery = AppointmentSchedule::query();
        $availableSlotsQuery = AppointmentSchedule::where('weekday', $weekday);
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

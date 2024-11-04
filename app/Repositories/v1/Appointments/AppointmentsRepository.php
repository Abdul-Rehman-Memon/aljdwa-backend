<?php

namespace App\Repositories\v1\Appointments;

use App\Models\Appointment;
use App\Models\AppointmentSchedule;
use Carbon\Carbon;
use DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

use App\Mail\AppointmentConfirmationForVisitor;
use App\Mail\AppointmentNotificationForAdmin;
use App\Mail\AppointmentStatusNotification;

class AppointmentsRepository implements AppointmentsInterface
{
    public function createAppointment(array $data)
    {
        // Disable timestamps for this model
        // Appointment::unsetEventDispatcher();
        // return $data;
        // return Appointment::create($data);

        // Re-enable event dispatcher if needed later in the application
            // Appointment::setEventDispatcher(app('events'));

        // Create the appointment
        $appointment = Appointment::create($data);

        // Format the dates for the emails
        $data['request_date'] = Carbon::createFromTimestamp($data['request_date'])->format('F j, Y');
        $data['request_time'] = Carbon::createFromTimestamp($data['request_time'])->format('g:i A');


        // Send email to visitor
        Mail::to($data['email'])->send(new AppointmentConfirmationForVisitor($data));

        // Send email to admin
        $adminEmail = config('mail.admin_email'); // Make sure this is configured in your .env
        Mail::to($adminEmail)->send(new AppointmentNotificationForAdmin($data));

        return $appointment;    
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
        $data['approved_by'] = Auth::id();

        $appointment = Appointment::with('appointment_status')->find($appointmentId);

        if (!$appointment) {
            return null;  // Handle this scenario appropriately, e.g., throw an exception
        }

        // Update the appointment data in the database
        $appointment->update($data);

        // Format `request_date` and `request_time` as human-readable for the email
        $appointment->request_date = Carbon::createFromTimestamp($appointment->request_date)->format('F j, Y');
        $appointment->request_time = Carbon::createFromTimestamp($appointment->request_time)->format('g:i A');
        
        $email_data = $appointment;
        $email_data['status'] = $email_data['appointment_status']['value'];
        // Send notification email based on the status
        Mail::to($appointment->email)->send(new AppointmentStatusNotification($email_data));

        return $appointment;
        
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

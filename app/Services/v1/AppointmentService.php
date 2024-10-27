<?php
namespace App\Services\v1;

use App\Repositories\v1\Appointments\AppointmentsInterface;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
class AppointmentService
{
    protected $appointmentRepository;

    public function __construct(AppointmentsInterface $appointmentRepository)
    {
        $this->appointmentRepository = $appointmentRepository;
    }

    public function createAppointment(array $data)
    {
        $appointment = $this->appointmentRepository->createAppointment($data);

        return $appointment;
    }

    public function getAllAppointments($limit, $offset)
    {
        $appointments = $this->appointmentRepository->getAllAppointments($limit, $offset);

        return $appointments;
    }

    public function getSingleAppointment($appointmentId)
    {
        $appointment = $this->appointmentRepository->getSingleAppointment($appointmentId);

        return $appointment;
    }

    public function updateAppointment($data, $appointmentId)
    {
        $appointment = $this->appointmentRepository->updateAppointment($data, $appointmentId);

        return $appointment;
    }

    public function AppointmentSchedules($data)
    {
        $appointment_schedule = $this->appointmentRepository->AppointmentSchedules($data);

        return $appointment_schedule;
    }

    public function AvailableAppointmentSlots($data)
    {
        $appointment_schedule = $this->appointmentRepository->AvailableAppointmentSlots($data);

        return $appointment_schedule;
    }

}

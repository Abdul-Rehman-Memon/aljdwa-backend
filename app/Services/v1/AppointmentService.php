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
}

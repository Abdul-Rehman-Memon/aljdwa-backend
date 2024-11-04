<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Repositories\v1\Users\UserRepositoryInterface as UserRepositoryV1;
use App\Repositories\v1\Users\UserRepository as UserRepositoryImplV1;

use App\Repositories\v1\Appointments_schedule\AppointmentsScheduleInterface as AppointmentsScheduleInterfaceV1;
use App\Repositories\v1\Appointments_schedule\AppointmentsScheduleRepository as AppointmentsScheduleRepositoryV1;

use App\Repositories\v1\Appointments\AppointmentsInterface as AppointmentsInterfaceV1;
use App\Repositories\v1\Appointments\AppointmentsRepository as AppointmentsRepositoryV1;

use App\Repositories\v1\Entrepreneur_details\EntrepreneurDetailsInterface as EntrepreneurDetailsInterfaceV1;
use App\Repositories\v1\Entrepreneur_details\EntrepreneurDetailsRepository as EntrepreneurDetailsRepositoryV1;

use App\Repositories\v1\Meetings\MeetingsInterface as MeetingsInterfaceV1;
use App\Repositories\v1\Meetings\MeetingsRepository as MeetingsRepositoryV1;

use App\Repositories\v1\Entrepreneur_agreement\EntrepreneurAgreementInterface as EntrepreneurAgreementInterfaceV1;
use App\Repositories\v1\Entrepreneur_agreement\EntrepreneurAgreementRepository as EntrepreneurAgreementRepositoryV1;

use App\Repositories\v1\Payments\PaymentsInterface as PaymentsInterfaceV1;
use App\Repositories\v1\Payments\PaymentsRepository as PaymentsRepositoryV1;

use App\Repositories\v1\Mentors_assignment\MentorsAssignmentInterface as MentorsAssignmentInterfaceV1;
use App\Repositories\v1\Mentors_assignment\MentorsAssignmentRepository as MentorsAssignmentRepositoryV1;

use App\Repositories\v1\Messages\MessagesInterface as MessagesInterfaceV1;
use App\Repositories\v1\Messages\MessagesRepository as MessagesRepositoryV1;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Bind for v1 - User Repository
        $this->app->bind(UserRepositoryV1::class, UserRepositoryImplV1::class);

        // Bind for v1 - Appointments Schedule Repository
        $this->app->bind(AppointmentsScheduleInterfaceV1::class, AppointmentsScheduleRepositoryV1::class);

        // Bind for v1 - Appointments Repository
        $this->app->bind(AppointmentsInterfaceV1::class, AppointmentsRepositoryV1::class);

        // Bind for v1 - Entrepreneur Details Repository
        $this->app->bind(EntrepreneurDetailsInterfaceV1::class, EntrepreneurDetailsRepositoryV1::class);

        // Bind for v1 - Meetings Repository
        $this->app->bind(MeetingsInterfaceV1::class, MeetingsRepositoryV1::class);

        // Bind for v1 - Entrepreneur Agreement Repository
        $this->app->bind(EntrepreneurAgreementInterfaceV1::class, EntrepreneurAgreementRepositoryV1::class);

        // Bind for v1 - Entrepreneur Payment Repository
         $this->app->bind(PaymentsInterfaceV1::class, PaymentsRepositoryV1::class);

        // Bind for v1 - Mentor Assignemnt Repository
        $this->app->bind(MentorsAssignmentInterfaceV1::class, MentorsAssignmentRepositoryV1::class);

        // Bind for v1 - Messages Repository
        $this->app->bind(MessagesInterfaceV1::class, MessagesRepositoryV1::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}

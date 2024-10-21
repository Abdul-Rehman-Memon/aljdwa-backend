<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\v1\Users\UserRepositoryInterface as UserRepositoryV1;
use App\Repositories\v1\Users\UserRepository as UserRepositoryImplV1;

use App\Repositories\v1\Entreprenuer_details\EntreprenuerDetailsInterface as EntreprenuerDetailsInterfaceV1;
use App\Repositories\v1\Entreprenuer_details\EntreprenuerDetailsRepository as EntreprenuerDetailsRepositoryV1;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Bind for v1 - User Repository
        $this->app->bind(UserRepositoryV1::class, UserRepositoryImplV1::class);

        // Bind for v1 - Startup Details Repository
        $this->app->bind(EntreprenuerDetailsInterfaceV1::class, EntreprenuerDetailsRepositoryV1::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}

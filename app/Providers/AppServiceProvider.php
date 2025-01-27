<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

// SERVICES:
use App\Repositories\Services\AdminService;
use App\Repositories\Services\RegistrarService;
use App\Repositories\Services\RegistrationService;
use App\Repositories\Services\StudentService;
use App\Repositories\Services\TrainerService;

//INTERFACES:
use App\Repositories\Interfaces\AdminInterface;
use App\Repositories\Interfaces\RegistrarInterface;
use App\Repositories\Interfaces\RegistrationInterface;
use App\Repositories\Interfaces\StudentInterface;
use App\Repositories\Interfaces\TrainerInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(AdminInterface::class, AdminService::class);
        $this->app->bind(RegistrarInterface::class, RegistrarService::class);
        $this->app->bind(RegistrationInterface::class, RegistrationService::class);
        $this->app->bind(StudentInterface::class, StudentService::class);
        $this->app->bind(TrainerInterface::class, TrainerService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (config('app.env') === 'production') {
            URL::forceScheme('https');
        }
    }
}

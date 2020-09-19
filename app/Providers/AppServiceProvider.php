<?php

namespace App\Providers;

use App\Models\Student;
use App\Models\User;
use App\Observers\StudentObserver;
use App\Observers\WebinarRecurrenceObserver;
use App\Webinar;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        //

    }
}

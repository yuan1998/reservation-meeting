<?php

namespace App\Providers;

use App\Models\ReservationMeeting;
use App\Observers\ReservationMeetingObserver;
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
        ReservationMeeting::observe(ReservationMeetingObserver::class);
    }
}

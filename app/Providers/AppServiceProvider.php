<?php

namespace App\Providers;

use App\Domains\User\Repositories\UserRepositoryInterface;
use App\Infrastructure\Repositories\UserRepository;
use App\Domains\Arenas\Repositories\ArenaRepositoryInterface;
use App\Infrastructure\Repositories\ArenaRepository;
use App\Domains\Arenas\Repositories\TimeSlotRepositoryInterface;
use App\Infrastructure\Repositories\TimeSlotRepository;
use App\Domains\Bookings\Repositories\BookingRepositoryInterface;
use App\Infrastructure\Repositories\BookingRepository;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(ArenaRepositoryInterface::class, ArenaRepository::class);
        $this->app->bind(TimeSlotRepositoryInterface::class, TimeSlotRepository::class);
        $this->app->bind(BookingRepositoryInterface::class, BookingRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}

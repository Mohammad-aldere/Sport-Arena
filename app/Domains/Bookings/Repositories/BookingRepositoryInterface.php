<?php

namespace App\Domains\Bookings\Repositories;

use App\Domains\Bookings\Entities\Booking;

interface BookingRepositoryInterface
{
    public function create(array $data): Booking;
    public function findByArenaAndTimeSlot($arenaId, $timeSlotId): ?Booking;
    public function updateStatus(Booking $booking, string $status): Booking;
}

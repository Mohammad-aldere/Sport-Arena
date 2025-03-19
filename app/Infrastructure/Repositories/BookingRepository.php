<?php

namespace App\Infrastructure\Repositories;

use App\Domains\Bookings\Repositories\BookingRepositoryInterface;
use App\Domains\Bookings\Entities\Booking;


class BookingRepository implements BookingRepositoryInterface
{
    public function create(array $data): Booking
    {
        return Booking::create($data);
    }

    public function findByArenaAndTimeSlot($arenaId, $timeSlotId): ?Booking
    {
        return Booking::where('arena_id', $arenaId)
            ->where('time_slot_id', $timeSlotId)
            ->where('status', 'pending')
            ->first();
    }

    public function updateStatus(Booking $booking, string $status): Booking
    {
        $booking->status = $status;
        $booking->save();

        return $booking;
    }
}

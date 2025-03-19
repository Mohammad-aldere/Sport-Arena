<?php

namespace App\Domains\Bookings\Services;

use App\Domains\Bookings\Repositories\BookingRepositoryInterface;
use App\Domains\Arenas\Repositories\TimeSlotRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\DB;
use App\Jobs\ReleaseUnconfirmedBooking;


class BookingService
{
    protected $bookingRepository;
    protected $timeSlotRepository;

    public function __construct(
        BookingRepositoryInterface $bookingRepository,
        TimeSlotRepositoryInterface $timeSlotRepository
    ) {
        $this->bookingRepository = $bookingRepository;
        $this->timeSlotRepository = $timeSlotRepository;
    }

    public function reserveSlot($arenaId, $timeSlotId, $userId)
    {
        DB::beginTransaction();
        try {

            $timeSlot = $this->timeSlotRepository->find($timeSlotId);

            if (!$timeSlot || $timeSlot->arena_id !== $arenaId) {
                throw new Exception('Invalid time slot for this arena.');
            }

     
            $existingBooking = $this->bookingRepository->findByArenaAndTimeSlot($arenaId, $timeSlotId);
            if ($existingBooking) {
                throw new Exception('This time slot is already reserved.');
            }


            $bookingData = [
                'arena_id' => $arenaId,
                'user_id' => $userId,
                'time_slot_id' => $timeSlotId,
                'status' => 'pending'
            ];

            $booking = $this->bookingRepository->create($bookingData);

            ReleaseUnconfirmedBooking::dispatch($booking)->delay(now()->addMinutes(10));



            DB::commit();

            return $booking;
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception('Error reserving time slot: ' . $e->getMessage());
        }
    }

}

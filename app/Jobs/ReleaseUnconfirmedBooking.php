<?php

namespace App\Jobs;

use App\Domains\Bookings\Entities\Booking;
use App\Domains\Bookings\Repositories\BookingRepositoryInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ReleaseUnconfirmedBooking implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $booking;

    public function __construct(Booking $booking)
    {
        $this->booking = $booking;
    }

    public function handle(BookingRepositoryInterface $bookingRepositoryInterface)
    {
        $expirationTime = now()->subMinutes(10);

        if ($this->booking->created_at->lt($expirationTime) && $this->booking->status === 'pending') {
            $bookingRepositoryInterface->updateStatus($this->booking, 'cancelled');
        }
    }
}

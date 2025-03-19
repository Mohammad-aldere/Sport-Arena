<?php

namespace App\Http\Controllers;

use App\Domains\Bookings\Services\BookingService;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    protected $bookingService;

    public function __construct(BookingService $bookingService)
    {
        $this->bookingService = $bookingService;
    }

    public function reserve(Request $request)
    {
        $validated = $request->validate([
            'arena_id' => 'required|exists:arenas,id',
            'time_slot_id' => 'required|exists:time_slots,id',
        ]);

        try {
            $booking = $this->bookingService->reserveSlot(
                (int)$validated['arena_id'],
                (int)$validated['time_slot_id'],
                auth()->id() 
            );

            return response()->json($booking, 201);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}

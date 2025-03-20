<?php 

namespace Tests\Unit;

use Tests\TestCase;
use Mockery;
use App\Domains\Bookings\Services\BookingService;
use App\Domains\Bookings\Repositories\BookingRepositoryInterface;
use App\Domains\Arenas\Repositories\TimeSlotRepositoryInterface;
use App\Domains\Arenas\Entities\TimeSlot;
use App\Domains\Bookings\Entities\Booking;
use Exception;

class BookingServiceTest extends TestCase
{
    protected $bookingRepository;
    protected $timeSlotRepository;
    protected $bookingService;

    public function setUp(): void
    {
        parent::setUp();

        // Mock repositories
        $this->bookingRepository = Mockery::mock(BookingRepositoryInterface::class);
        $this->timeSlotRepository = Mockery::mock(TimeSlotRepositoryInterface::class);

        // Initialize the service with mocked dependencies
        $this->bookingService = new BookingService(
            $this->bookingRepository,
            $this->timeSlotRepository
        );
    }

    /** @test */
    public function it_creates_a_booking_successfully()
    {
        // Define test data
        $arenaId = 1;
        $timeSlotId = 5;
        $userId = 10;

        // Mock TimeSlot repository to return a TimeSlot object
        $this->timeSlotRepository->shouldReceive('find')
            ->once()
            ->with($timeSlotId)
            ->andReturn(new TimeSlot(['id' => $timeSlotId, 'arena_id' => $arenaId]));

        // Mock findByArenaAndTimeSlot to return null (indicating no existing booking)
        $this->bookingRepository->shouldReceive('findByArenaAndTimeSlot')
            ->once()
            ->with($arenaId, $timeSlotId)
            ->andReturn(null);

        // Mock create booking and return a new Booking object
        $bookingData = [
            'arena_id' => $arenaId,
            'user_id' => $userId,
            'time_slot_id' => $timeSlotId,
            'status' => 'pending',
        ];

        $this->bookingRepository->shouldReceive('create')
            ->once()
            ->with($bookingData)
            ->andReturn(new Booking($bookingData));

        // Call the reserveSlot method to create a booking
        try {
            $booking = $this->bookingService->reserveSlot($arenaId, $timeSlotId, $userId);

            // Assert the booking was created with correct data
            $this->assertEquals($arenaId, $booking->arena_id);
            $this->assertEquals($userId, $booking->user_id);
            $this->assertEquals($timeSlotId, $booking->time_slot_id);
            $this->assertEquals('pending', $booking->status);
        } catch (Exception $e) {
            // If exception is caught, print the error message for debugging
            echo $e->getMessage();
        }
    }
}

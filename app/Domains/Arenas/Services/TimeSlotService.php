<?php
namespace App\Domains\Arenas\Services;

use App\Domains\Arenas\Repositories\TimeSlotRepositoryInterface;
use Carbon\Carbon;

class TimeSlotService
{
    protected $timeSlotRepository;

    public function __construct(TimeSlotRepositoryInterface $timeSlotRepository)
    {
        $this->timeSlotRepository = $timeSlotRepository;
    }

    public function createDefaultSlots($arenaId, $duration)
    {
        $start = Carbon::createFromTime(8, 0, 0); 
        $end = Carbon::createFromTime(23, 0, 0); 

        while ($start->lt($end)) {
            $slotEnd = $start->copy()->addMinutes((int) $duration);
            
            $this->timeSlotRepository->create([
                'arena_id'   => $arenaId,
                'start_time' => $start->format('H:i:s'),
                'end_time'   => $slotEnd->format('H:i:s'),
            ]);

            $start = $slotEnd; 
        }
    }
}

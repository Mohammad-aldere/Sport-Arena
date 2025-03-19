<?php
namespace App\Domains\Arenas\Services;

use App\Domains\Arenas\Repositories\ArenaRepositoryInterface;
use App\Domains\Arenas\Services\TimeSlotService;
use Illuminate\Support\Facades\DB;
use Exception;

class ArenaService {
    protected $arenaRepository;
    protected $timeSlotService;

    public function __construct(ArenaRepositoryInterface $arenaRepository, TimeSlotService $timeSlotService)
    {
        $this->arenaRepository = $arenaRepository;
        $this->timeSlotService = $timeSlotService;
    }
    public function createArena(array $data) {

            $data['owner_id'] = auth()->id();
            return DB::transaction(function () use ($data) {
                $arena = $this->arenaRepository->create($data);
                $this->timeSlotService->createDefaultSlots($arena->id, $data['duration']);
                return $arena;
            }, 3);
    
    }
    
}

<?php

namespace App\Infrastructure\Repositories;

use App\Domains\Arenas\Repositories\TimeSlotRepositoryInterface;
use App\Domains\Arenas\Entities\TimeSlot;


class TimeSlotRepository implements TimeSlotRepositoryInterface
{
    public function create(array $data): TimeSlot
    {   
        return TimeSlot::create($data);
    }

    public function find($id): ?TimeSlot
    {
        return TimeSlot::find($id);
    }
}

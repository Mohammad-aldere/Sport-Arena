<?php

namespace App\Domains\Arenas\Repositories;


use App\Domains\Arenas\Entities\TimeSlot;

interface TimeSlotRepositoryInterface {
    public function create(array $data): TimeSlot;
    public function find($id): ?TimeSlot;
}


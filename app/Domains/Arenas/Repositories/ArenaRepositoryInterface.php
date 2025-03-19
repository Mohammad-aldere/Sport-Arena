<?php

namespace App\Domains\Arenas\Repositories;

use App\Domains\Arenas\Entities\Arena;

interface ArenaRepositoryInterface {
    public function create(array $data): Arena;
}

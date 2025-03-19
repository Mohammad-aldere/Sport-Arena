<?php
namespace App\Infrastructure\Repositories;

use App\Domains\Arenas\Entities\Arena;
use App\Domains\Arenas\Repositories\ArenaRepositoryInterface;


class ArenaRepository implements ArenaRepositoryInterface {
    public function create(array $data): Arena {
        
        return Arena::create($data);
        
    }
    
}

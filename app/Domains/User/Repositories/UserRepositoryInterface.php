<?php

namespace App\Domains\User\Repositories;

use App\Domains\User\Entities\User;

interface UserRepositoryInterface
{
    public function create(array $data): User;
    public function findByEmail(string $email): ?User;
}

<?php

namespace App\Infrastructure\Repositories;

use App\Domains\User\Repositories\UserRepositoryInterface;
use App\Domains\User\Entities\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
class UserRepository implements UserRepositoryInterface
{
    public function create(array $data): User
    {
        $data['password'] = Hash::make($data['password']);
        return DB::transaction(function () use ($data) {
            return User::create($data);
        },3);
    }

    public function findByEmail(string $email): ?User
    {
        return User::where('email', $email)->first();
    }
}

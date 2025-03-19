<?php

namespace App\Domains\User\Services;

use App\Domains\User\Repositories\UserRepositoryInterface;
use App\Domains\User\Entities\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class UserService
{
    protected $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }


    public function register(array $data)
    {
        try {
            return DB::transaction(function () use ($data) {

                $user = $this->userRepository->create($data);

                return $user;
            });
        } catch (\Exception $e) {
            throw new \Exception('An error occurred during user registration: ' . $e->getMessage());
        }
    }


    public function login(string $email, string $password): ?User
    {
        $user = $this->userRepository->findByEmail($email);

        if (!$user || !Hash::check($password, $user->password)) {
            return null;
        }

        return $user;
    }

    public function logout(Request $request)
    {

        $user = $request->user();

        $user->tokens->each(function ($token) {
            $token->delete();
        });
        return true;
    }
}

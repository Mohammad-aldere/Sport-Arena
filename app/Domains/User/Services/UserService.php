<?php

namespace App\Domains\User\Services;

use App\Domains\User\Repositories\UserRepositoryInterface;
use App\Domains\User\Entities\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class UserService
{
    protected $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }


    public function register(array $data): User
    {   
        $data['role'] = 'admin';
        return $this->userRepository->create($data);
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

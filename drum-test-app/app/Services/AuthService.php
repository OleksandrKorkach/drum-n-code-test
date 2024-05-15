<?php

namespace App\Services;

use App\DTOs\Auth\LoginUserDTO;
use App\DTOs\Auth\RegisterUserDTO;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function register(RegisterUserDTO $dto): JsonResponse
    {
        $userData = $dto->toArray();
        $userData['password'] = $this->getHashedPassword($userData['password']);

        $user = $this->userRepository->create($userData);

        $token = $this->createAuthToken($user);
        return response()->json(['access_token' => $token, 'token_type' => 'Bearer']);
    }

    public function login(LoginUserDTO $dto): JsonResponse
    {
        $userData = $dto->toArray();
        $user = $this->userRepository->getByEmail($userData['email']);
        $token = $this->createAuthToken($user);

        return response()->json(['access_token' => $token, 'token_type' => 'Bearer']);
    }

    public function logout(Request $request): void
    {
        $request->user()->tokens()->delete();
    }

    private function createAuthToken(User $user): string
    {
        return $user->createToken('auth_token')->plainTextToken;
    }

    private function getHashedPassword(string $password): string
    {
        return Hash::make($password);
    }

}

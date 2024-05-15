<?php

namespace App\Http\Controllers;

use App\DTOs\Auth\LoginUserDTO;
use App\DTOs\Auth\RegisterUserDTO;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    private AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function register(RegisterRequest $request): JsonResponse
    {
        $registerUserDTO = RegisterUserDTO::fromRequest($request);
        return $this->authService->register($registerUserDTO);
    }

    public function login(LoginRequest $request): JsonResponse
    {
        if (!$request->authenticate()) {
            return response()->json(['message' => 'Invalid login details'], 401);
        }

        $loginUserDTO = LoginUserDTO::fromRequest($request);

        return $this->authService->login($loginUserDTO);
    }

    public function logout(Request $request): JsonResponse
    {
        $this->authService->logout($request);
        return response()->json(['message' => 'Successfully logged out']);
    }
}

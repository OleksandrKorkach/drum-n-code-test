<?php

namespace App\DTOs\Auth;

use App\Http\Requests\Auth\LoginRequest;

class LoginUserDTO
{
    public string $email;
    public string $password;

    public function __construct(string $email, string $password)
    {
        $this->email = $email;
        $this->password = $password;
    }

    public static function fromRequest(LoginRequest $request): LoginUserDTO
    {
        return new self(
            $request->input('email'),
            $request->input('password')
        );
    }

    public function toArray(): array
    {
        return [
            'email' => $this->email,
            'password' => $this->password,
        ];
    }
}

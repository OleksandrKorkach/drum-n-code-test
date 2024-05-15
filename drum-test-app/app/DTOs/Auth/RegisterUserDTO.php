<?php

namespace App\DTOs\Auth;

use App\Http\Requests\Auth\RegisterRequest;

class RegisterUserDTO
{
    public string $name;
    public string $email;
    public string $password;

    public function __construct(string $name, string $email, string $password)
    {
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
    }

    public static function fromRequest(RegisterRequest $request): RegisterUserDTO
    {
        return new self(
            $request->input('name'),
            $request->input('email'),
            $request->input('password')
        );
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
            'password' => $this->password,
        ];
    }
}

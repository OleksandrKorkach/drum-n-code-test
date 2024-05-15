<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    public function create(array $data): User
    {
        return User::create($data);
    }

    public function getByEmail(string $email)
    {
        return User::where('email', $email)->firstOrFail();
    }
}

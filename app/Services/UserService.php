<?php

namespace App\Services;

use App\Models\User;

class UserService
{
    public function store(array $data): User
    {
        return User::create($data);
    }
}

<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Auth;

class UserService
{
    public function store(array $data): User
    {
        return User::create($data);
    }

    public function login(array $credentials): ?Authenticatable
    {
        if (Auth::attempt($credentials)) {
            return auth()->user();
        }

        return null;
    }
}

<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    public function update(User $user): bool
    {
        return $user->id === auth()->id();
    }
}

<?php

namespace App\Policies;

use App\Enums\UserRole;
use App\Models\User;

class UserPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasRole(UserRole::Admin);
    }

    public function update(User $actor, User $user): bool
    {
        return $actor->hasRole(UserRole::Admin) || $actor->id === $user->id;
    }
}

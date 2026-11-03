<?php

namespace App\Policies;

use App\Enums\UserRole;
use App\Models\Team;
use App\Models\User;

class TeamPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasRole(UserRole::Admin);
    }

    public function view(User $user, Team $team): bool
    {
        return $user->hasRole(UserRole::Admin)
            || $user->teams()->where('teams.id', $team->id)->exists();
    }

    public function create(User $user): bool
    {
        return $user->hasRole(UserRole::Admin);
    }

    public function update(User $user, Team $team): bool
    {
        return $user->hasRole(UserRole::Admin);
    }

    public function delete(User $user, Team $team): bool
    {
        return $user->hasRole(UserRole::Admin);
    }
}

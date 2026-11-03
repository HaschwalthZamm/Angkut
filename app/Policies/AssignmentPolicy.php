<?php

namespace App\Policies;

use App\Enums\UserRole;
use App\Models\Assignment;
use App\Models\User;

class AssignmentPolicy
{
    public function create(User $user): bool
    {
        return $user->hasRole(UserRole::Admin);
    }

    public function view(User $user, Assignment $assignment): bool
    {
        if ($user->hasRole(UserRole::Admin)) {
            return true;
        }

        return $user->teams()->where('teams.id', $assignment->team_id)->exists();
    }
}

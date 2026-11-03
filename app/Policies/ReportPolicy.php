<?php

namespace App\Policies;

use App\Enums\ReportStatus;
use App\Enums\UserRole;
use App\Models\Report;
use App\Models\User;

class ReportPolicy
{
    public function view(User $user, Report $report): bool
    {
        if ($user->hasRole(UserRole::Admin)) {
            return true;
        }

        if ($user->hasRole(UserRole::Masyarakat)) {
            return $report->user_id === $user->id;
        }

        if ($user->hasRole(UserRole::Petugas)) {
            return $user->teams()->where('teams.id', $report->latestAssignment?->team_id)->exists();
        }

        return false;
    }

    public function update(User $user, Report $report): bool
    {
        return $user->hasRole(UserRole::Masyarakat)
            && $report->user_id === $user->id
            && $report->status === ReportStatus::Pending;
    }

    public function verify(User $user, Report $report): bool
    {
        return $user->hasRole(UserRole::Admin);
    }

    public function assign(User $user, Report $report): bool
    {
        return $user->hasRole(UserRole::Admin);
    }

    public function updateStatus(User $user, Report $report): bool
    {
        return $user->hasRole(UserRole::Petugas)
            && $user->teams()->where('teams.id', $report->latestAssignment?->team_id)->exists();
    }

    public function viewAnyGuest(string $token, Report $report): bool
    {
        return $report->guest_token === $token;
    }
}

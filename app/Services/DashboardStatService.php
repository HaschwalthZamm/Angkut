<?php

namespace App\Services;

use App\Enums\ReportStatus;
use App\Enums\UserRole;
use App\Models\Report;
use App\Models\Team;
use App\Models\User;

class DashboardStatService
{
    /**
     * @return array<string, int>
     */
    public function admin(): array
    {
        return [
            'total_reports' => Report::query()->count(),
            'pending' => Report::query()->where('status', ReportStatus::Pending)->count(),
            'on_progress' => Report::query()->where('status', ReportStatus::OnProgress)->count(),
            'completed' => Report::query()->where('status', ReportStatus::Completed)->count(),
            'teams' => Team::query()->count(),
            'petugas' => User::role(UserRole::Petugas->value)->count(),
        ];
    }

    /**
     * @return array<string, int>
     */
    public function masyarakat(User $user): array
    {
        $query = Report::query()->where('user_id', $user->id);

        return [
            'total' => (clone $query)->count(),
            'pending' => (clone $query)->where('status', ReportStatus::Pending)->count(),
            'completed' => (clone $query)->where('status', ReportStatus::Completed)->count(),
        ];
    }

    /**
     * @return array<string, int>
     */
    public function petugas(User $user): array
    {
        $teamIds = $user->teams()->pluck('teams.id');

        $query = Report::query()->whereHas('assignments', fn ($q) => $q->whereIn('team_id', $teamIds));

        return [
            'assigned' => (clone $query)->where('status', ReportStatus::Assigned)->count(),
            'on_progress' => (clone $query)->where('status', ReportStatus::OnProgress)->count(),
            'completed' => (clone $query)->where('status', ReportStatus::Completed)->count(),
        ];
    }
}

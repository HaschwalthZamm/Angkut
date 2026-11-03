<?php

namespace App\Services;

use App\Enums\TeamStatus;
use App\Models\Team;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class TeamService
{
    /**
     * @param  array<string, mixed>  $data
     */
    public function create(array $data): Team
    {
        return Team::query()->create([
            'name' => $data['name'],
            'region_id' => $data['region_id'],
            'status' => TeamStatus::tryFrom($data['status'] ?? '') ?? TeamStatus::Active,
            'description' => $data['description'] ?? null,
        ]);
    }

    /**
     * @param  array<string, mixed>  $data
     */
    public function update(Team $team, array $data): Team
    {
        $team->update([
            'name' => $data['name'] ?? $team->name,
            'region_id' => $data['region_id'] ?? $team->region_id,
            'status' => isset($data['status'])
                ? (TeamStatus::tryFrom($data['status']) ?? $team->status)
                : $team->status,
            'description' => $data['description'] ?? $team->description,
        ]);

        return $team;
    }

    public function addMember(Team $team, User $user, bool $isLeader = false): void
    {
        DB::transaction(function () use ($team, $user, $isLeader) {
            $team->members()->updateOrCreate(
                ['user_id' => $user->id],
                ['is_leader' => $isLeader],
            );
        });
    }
}

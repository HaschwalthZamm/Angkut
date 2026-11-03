<?php

namespace App\Http\Middleware;

use App\Models\Report;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureTeamMembership
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();
        $report = $request->route('report');

        if (! $report instanceof Report) {
            return $next($request);
        }

        $teamIds = $user?->teams()->pluck('teams.id') ?? collect();
        $assignedTeamId = $report->latestAssignment?->team_id;

        if (! $assignedTeamId || ! $teamIds->contains($assignedTeamId)) {
            abort(403, 'Petugas hanya dapat mengakses tugas tim sendiri.');
        }

        return $next($request);
    }
}

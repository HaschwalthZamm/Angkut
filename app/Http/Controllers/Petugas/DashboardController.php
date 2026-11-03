<?php

namespace App\Http\Controllers\Petugas;

use App\Enums\ReportStatus;
use App\Http\Controllers\Controller;
use App\Models\Report;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $team = $request->user()->activeTeam();

        if (!$team) {
            return response()->json([
                'success' => true,
                'team'    => null,
                'data'    => [
                    'message' => 'Anda belum tergabung dalam tim manapun.',
                ],
            ]);
        }

        $taskQuery = Report::query()
            ->whereHas('activeAssignment', fn ($q) => $q->where('team_id', $team->id)->where('is_active', true));

        return response()->json([
            'success' => true,
            'team'    => [
                'id'   => $team->id,
                'name' => $team->name,
                'region' => $team->region?->name,
            ],
            'data'    => [
                'assigned'    => (clone $taskQuery)->where('status', ReportStatus::Assigned)->count(),
                'on_progress' => (clone $taskQuery)->where('status', ReportStatus::OnProgress)->count(),
                'completed_today' => (clone $taskQuery)
                    ->where('status', ReportStatus::Completed)
                    ->whereDate('completed_at', today())
                    ->count(),
                'overdue'     => (clone $taskQuery)
                    ->whereIn('status', [ReportStatus::Assigned, ReportStatus::OnProgress])
                    ->where('sla_deadline_at', '<', now())
                    ->count(),
            ],
        ]);
    }
}
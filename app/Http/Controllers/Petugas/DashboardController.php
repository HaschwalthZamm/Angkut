<?php

namespace App\Http\Controllers\Petugas;

use App\Enums\ReportStatus;
use App\Http\Controllers\Controller;
use App\Models\Report;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $team = $request->user()->activeTeam();

        if (!$team) {
            return view('petugas.dashboard', [
                'team' => null,
                'stats' => [],
                'recentTasks' => collect(),
            ]);
        }

        $taskQuery = Report::query()
            ->whereHas('activeAssignment', fn ($q) => $q->where('team_id', $team->id)->where('is_active', true));

        $stats = [
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
        ];

        $recentTasks = (clone $taskQuery)
            ->with(['region', 'category'])
            ->whereIn('status', [ReportStatus::Assigned, ReportStatus::OnProgress])
            ->orderBy('sla_deadline_at', 'asc')
            ->limit(5)
            ->get();

        return view('petugas.dashboard', compact('team', 'stats', 'recentTasks'));
    }
}
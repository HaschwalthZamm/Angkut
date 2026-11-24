<?php

namespace App\Http\Controllers\Petugas;

use App\Enums\ReportStatus;
use App\Http\Controllers\Controller;
use App\Models\Assignment;
use App\Models\Report;
use Carbon\Carbon;
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
                'progressPercentage' => 0,
                'totalToday' => 0,
                'chartLabels' => [],
                'chartDataMasuk' => [],
                'chartDataSelesai' => [],
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

        // Hitung progres hari ini
        $totalToday = $stats['assigned'] + $stats['on_progress'] + $stats['completed_today'];
        $progressPercentage = $totalToday > 0 ? round(($stats['completed_today'] / $totalToday) * 100) : 0;

        // Ambil 5 tugas terdekat
        $recentTasks = (clone $taskQuery)
            ->with(['region', 'category'])
            ->whereIn('status', [ReportStatus::Assigned, ReportStatus::OnProgress])
            ->orderBy('sla_deadline_at', 'asc')
            ->limit(5)
            ->get();

        // ==========================================
        // LOGIKA DATA GRAFIK 7 HARI TERAKHIR
        // ==========================================
        $chartLabels = [];
        $chartDataMasuk = [];
        $chartDataSelesai = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $dateString = $date->format('Y-m-d');
            
            // Label hari (Sen, Sel, Rab, dll)
            $chartLabels[] = $date->translatedFormat('D');

            // Hitung tugas masuk (di-assign ke tim ini pada tanggal tersebut)
            $masuk = Assignment::where('team_id', $team->id)
                ->whereDate('assigned_at', $dateString)
                ->count();
            
            // Hitung tugas selesai (completed oleh tim ini pada tanggal tersebut)
            $selesai = Report::whereHas('activeAssignment', fn($q) => $q->where('team_id', $team->id))
                ->where('status', ReportStatus::Completed)
                ->whereDate('completed_at', $dateString)
                ->count();

            $chartDataMasuk[] = $masuk;
            $chartDataSelesai[] = $selesai;
        }

        return view('petugas.dashboard', compact(
            'team', 
            'stats', 
            'recentTasks', 
            'progressPercentage', 
            'totalToday',
            'chartLabels',
            'chartDataMasuk',
            'chartDataSelesai'
        ));
    }
}
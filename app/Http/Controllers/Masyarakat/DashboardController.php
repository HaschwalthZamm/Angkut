<?php

namespace App\Http\Controllers\Masyarakat;

use App\Enums\ReportStatus;
use App\Http\Controllers\Controller;
use App\Models\Report;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        // Hitung statistik laporan milik user ini
        $stats = [
            'total'       => Report::where('user_id', $user->id)->count(),
            'pending'     => Report::where('user_id', $user->id)->where('status', ReportStatus::Pending)->count(),
            'on_progress' => Report::where('user_id', $user->id)->whereIn('status', [ReportStatus::Assigned, ReportStatus::OnProgress])->count(),
            'completed'   => Report::where('user_id', $user->id)->whereIn('status', [ReportStatus::Completed, ReportStatus::Closed])->count(),
        ];

        // Ambil 5 laporan terbaru milik user
        $recentReports = Report::where('user_id', $user->id)
            ->with(['region', 'category'])
            ->orderByDesc('created_at')
            ->limit(5)
            ->get();

        return view('masyarakat.dashboard', compact('stats', 'recentReports'));
    }
}
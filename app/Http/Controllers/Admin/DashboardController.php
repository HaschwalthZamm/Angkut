<?php

namespace App\Http\Controllers\Admin;

use App\Enums\ReportStatus;
use App\Http\Controllers\Controller;
use App\Models\Assignment;
use App\Models\Report;
use App\Models\Team;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class DashboardController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data'    => [
                'reports' => [
                    'total'       => Report::count(),
                    'pending'     => Report::where('status', ReportStatus::Pending)->count(),
                    'verified'    => Report::where('status', ReportStatus::Verified)->count(),
                    'assigned'    => Report::where('status', ReportStatus::Assigned)->count(),
                    'on_progress' => Report::where('status', ReportStatus::OnProgress)->count(),
                    'completed'   => Report::where('status', ReportStatus::Completed)->count(),
                    'rejected'    => Report::where('status', ReportStatus::Rejected)->count(),
                    'closed'      => Report::where('status', ReportStatus::Closed)->count(),
                    'overdue'     => Report::where('status', '!=', ReportStatus::Completed)
                        ->where('status', '!=', ReportStatus::Closed)
                        ->where('status', '!=', ReportStatus::Rejected)
                        ->where('sla_deadline_at', '<', now())
                        ->count(),
                ],
                'users' => [
                    'total'      => User::count(),
                    'masyarakat' => User::role('masyarakat')->count(),
                    'petugas'    => User::role('petugas')->count(),
                    'admin'      => User::role('admin')->count(),
                ],
                'teams' => [
                    'total'  => Team::count(),
                    'active' => Team::where('status', 'active')->count(),
                ],
                'assignments' => [
                    'active' => Assignment::where('is_active', true)->count(),
                ],
            ],
        ]);
    }
}
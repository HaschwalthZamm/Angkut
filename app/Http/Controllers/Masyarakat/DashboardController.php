<?php

namespace App\Http\Controllers\Masyarakat;

use App\Enums\ReportStatus;
use App\Http\Controllers\Controller;
use App\Models\Report;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = Report::where('user_id', $request->user()->id);

        return response()->json([
            'success' => true,
            'data'    => [
                'total'       => (clone $query)->count(),
                'pending'     => (clone $query)->where('status', ReportStatus::Pending)->count(),
                'on_progress' => (clone $query)->whereIn('status', [ReportStatus::Assigned, ReportStatus::OnProgress])->count(),
                'completed'   => (clone $query)->where('status', ReportStatus::Completed)->count(),
                'rejected'    => (clone $query)->where('status', ReportStatus::Rejected)->count(),
                'recent'      => (clone $query)
                    ->with(['region', 'category'])
                    ->orderByDesc('created_at')
                    ->limit(5)
                    ->get(),
            ],
        ]);
    }
}
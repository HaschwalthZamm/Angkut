<?php

namespace App\Http\Controllers\Admin;

use App\Enums\ReportStatus;
use App\Http\Controllers\Controller;
use App\Models\Report;
use App\Services\ReportStatusService;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function __construct(private ReportStatusService $statusService) {}

    public function index(Request $request)
    {
        $query = Report::query()->with(['region', 'category', 'activeAssignment.team']);

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        if ($request->filled('region_id')) {
            $query->where('region_id', $request->input('region_id'));
        }

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('tracking_code', 'like', "%{$search}%")
                  ->orWhere('title', 'like', "%{$search}%")
                  ->orWhere('reporter_phone', 'like', "%{$search}%");
            });
        }

        $reports = $query->orderByDesc('created_at')->paginate(15);

        return view('admin.reports.index', compact('reports'));
    }

    public function show(Report $report)
    {
        $report->load([
            'region', 'category', 'user', 'verifier', 'images',
            'statusHistories.changer', 'activeAssignment.team.leader',
            'assignments.team', 'comments.user', 'feedback.user',
        ]);

        return response()->json(['success' => true, 'data' => $report]);
    }

    public function close(Request $request, Report $report)
    {
        $validated = $request->validate(['note' => 'nullable|string|max:500']);

        $report = $this->statusService->close(
            $report,
            $request->user(),
            $validated['note'] ?? null,
        );

        return back()->with('success', 'Laporan berhasil ditutup.');
    }
}
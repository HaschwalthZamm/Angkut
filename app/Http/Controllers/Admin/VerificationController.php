<?php

namespace App\Http\Controllers\Admin;

use App\Enums\ReportStatus;
use App\Http\Controllers\Controller;
use App\Models\Report;
use App\Services\ReportStatusService;
use Illuminate\Http\Request;

class VerificationController extends Controller
{
    public function __construct(private ReportStatusService $statusService) {}

    public function index(Request $request)
    {
        $reports = Report::query()
            ->where('status', ReportStatus::Pending)
            ->with(['region', 'category', 'user'])
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('admin.verifications.index', compact('reports'));
    }

    public function show(Report $report)
    {
        $report->load(['region', 'category', 'user', 'images', 'statusHistories']);
        return response()->json(['success' => true, 'data' => $report]);
    }

    public function verify(Request $request, Report $report)
    {
        $validated = $request->validate(['note' => 'nullable|string|max:500']);

        $this->statusService->verify(
            $report,
            $request->user(),
            $validated['note'] ?? null
        );

        return back()->with('success', 'Laporan berhasil diverifikasi!');
    }

    public function reject(Request $request, Report $report)
    {
        $validated = $request->validate(['reason' => 'required|string|max:1000']);

        $this->statusService->reject(
            $report,
            $request->user(),
            $validated['reason']
        );

        return back()->with('success', 'Laporan berhasil ditolak.');
    }
}
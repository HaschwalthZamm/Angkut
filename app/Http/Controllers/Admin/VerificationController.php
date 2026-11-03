<?php

namespace App\Http\Controllers\Admin;

use App\Enums\ReportStatus;
use App\Http\Controllers\Controller;
use App\Models\Report;
use App\Services\ReportStatusService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class VerificationController extends Controller
{
    public function __construct(private ReportStatusService $statusService) {}

    public function index(Request $request): JsonResponse
    {
        $reports = Report::query()
            ->where('status', ReportStatus::Pending)
            ->with(['region', 'category', 'user'])
            ->orderByDesc('created_at')
            ->paginate(20);

        return response()->json([
            'success' => true,
            'data'    => $reports,
        ]);
    }

    public function show(Report $report): JsonResponse
    {
        $report->load([
            'region',
            'category',
            'user',
            'images',
            'statusHistories',
        ]);

        return response()->json([
            'success' => true,
            'data'    => $report,
        ]);
    }

    public function verify(Request $request, Report $report): JsonResponse
    {
        $validated = $request->validate([
            'note' => 'nullable|string|max:500',
        ]);

        $report = $this->statusService->verify(
            $report,
            $request->user(),
            $validated['note'] ?? null,
        );

        return response()->json([
            'success' => true,
            'message' => 'Laporan berhasil diverifikasi.',
            'data'    => [
                'id'     => $report->id,
                'status' => $report->status->value,
            ],
        ]);
    }

    public function reject(Request $request, Report $report): JsonResponse
    {
        $validated = $request->validate([
            'reason' => 'required|string|max:1000',
        ]);

        $report = $this->statusService->reject(
            $report,
            $request->user(),
            $validated['reason'],
        );

        return response()->json([
            'success' => true,
            'message' => 'Laporan ditolak.',
            'data'    => [
                'id'              => $report->id,
                'status'          => $report->status->value,
                'rejected_reason' => $report->rejected_reason,
            ],
        ]);
    }
}
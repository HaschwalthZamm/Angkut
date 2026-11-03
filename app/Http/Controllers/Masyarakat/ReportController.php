<?php

namespace App\Http\Controllers\Masyarakat;

use App\Http\Controllers\Controller;
use App\Models\Report;
use App\Services\ReportService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function __construct(private ReportService $reportService) {}

    public function index(Request $request): JsonResponse
    {
        $reports = Report::query()
            ->where('user_id', $request->user()->id)
            ->with(['region', 'category', 'activeAssignment.team'])
            ->orderByDesc('created_at')
            ->paginate(20);

        return response()->json([
            'success' => true,
            'data'    => $reports,
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'region_id'          => 'required|exists:regions,id',
            'report_category_id' => 'required|exists:report_categories,id',
            'title'              => 'required|string|max:150',
            'description'        => 'required|string|max:2000',
            'latitude'           => 'required|numeric|between:-90,90',
            'longitude'          => 'required|numeric|between:-180,180',
            'address'            => 'nullable|string|max:255',
            'priority'           => 'nullable|in:low,medium,high,urgent',
        ]);

        $report = $this->reportService->createReport($validated, $request->user());

        return response()->json([
            'success' => true,
            'message' => 'Laporan berhasil dibuat.',
            'data'    => [
                'id'            => $report->id,
                'tracking_code' => $report->tracking_code,
                'status'        => $report->status->value,
                'title'         => $report->title,
            ],
        ], 201);
    }

    public function show(Request $request, Report $report): JsonResponse
    {
        if ($report->user_id !== $request->user()->id) {
            return response()->json([
                'success' => false,
                'message' => 'Anda tidak berhak melihat laporan ini.',
            ], 403);
        }

        $report->load([
            'region',
            'category',
            'images',
            'statusHistories',
            'activeAssignment.team',
            'feedback',
        ]);

        return response()->json([
            'success' => true,
            'data'    => $report,
        ]);
    }
}
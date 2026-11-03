<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Services\ReportService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PublicReportController extends Controller
{
    public function __construct(private ReportService $reportService) {}

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
            'reporter_name'      => 'required|string|max:100',
            'reporter_phone'     => 'required|string|max:20',
        ]);

        $report = $this->reportService->createReport($validated, null);

        return response()->json([
            'success' => true,
            'message' => 'Laporan berhasil dibuat. Simpan kode tracking untuk cek status.',
            'data'    => [
                'tracking_code' => $report->tracking_code,
                'reporter_phone' => $report->reporter_phone,
                'status'        => $report->status->value,
                'title'         => $report->title,
                'sla_deadline_at' => $report->sla_deadline_at?->toIso8601String(),
            ],
        ], 201);
    }
}
<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Services\ReportService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TrackingController extends Controller
{
    public function __construct(private ReportService $reportService) {}

    public function track(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'tracking_code' => 'required|string|max:30',
            'phone'         => 'required|string|max:20',
        ]);

        $report = $this->reportService->trackReport(
            $validated['tracking_code'],
            $validated['phone'],
        );

        if (!$report) {
            return response()->json([
                'success' => false,
                'message' => 'Laporan tidak ditemukan. Pastikan kode tracking dan nomor HP benar.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data'    => [
                'tracking_code'   => $report->tracking_code,
                'title'           => $report->title,
                'description'     => $report->description,
                'status'          => $report->status->value,
                'status_label'    => $report->status->label(),
                'priority'        => $report->priority->value,
                'region'          => $report->region?->name,
                'category'        => $report->category?->name,
                'address'         => $report->address,
                'latitude'        => (float) $report->latitude,
                'longitude'       => (float) $report->longitude,
                'reporter_name'   => $report->reporter_name,
                'handling_team'   => $report->activeAssignment?->team?->name,
                'sla_deadline_at' => $report->sla_deadline_at?->toIso8601String(),
                'completed_at'    => $report->completed_at?->toIso8601String(),
                'created_at'      => $report->created_at?->toIso8601String(),
                'images'          => $report->images->map(fn ($img) => [
                    'url'  => $img->url(),
                    'type' => $img->type,
                ]),
                'histories'       => $report->statusHistories->map(fn ($h) => [
                    'status'     => $h->status->value,
                    'status_label' => $h->status->label(),
                    'note'       => $h->note,
                    'created_at' => $h->created_at?->toIso8601String(),
                ]),
            ],
        ]);
    }
}
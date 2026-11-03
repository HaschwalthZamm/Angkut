<?php

namespace App\Http\Controllers\Petugas;

use App\Enums\ReportStatus;
use App\Http\Controllers\Controller;
use App\Models\Report;
use App\Services\AssignmentService;
use App\Services\ReportStatusService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class TaskController extends Controller
{
    public function __construct(
        private AssignmentService $assignmentService,
        private ReportStatusService $statusService,
    ) {}

    public function index(Request $request): JsonResponse
    {
        $team = $request->user()->activeTeam();

        if (!$team) {
            return response()->json([
                'success' => true,
                'message' => 'Anda belum tergabung dalam tim manapun.',
                'data'    => [],
            ]);
        }

        $reports = Report::query()
            ->whereHas('activeAssignment', fn ($q) => $q->where('team_id', $team->id)->where('is_active', true))
            ->whereIn('status', [ReportStatus::Assigned, ReportStatus::OnProgress])
            ->with(['region', 'category', 'activeAssignment'])
            ->orderByDesc('created_at')
            ->paginate(20);

        return response()->json([
            'success' => true,
            'team'    => [
                'id'   => $team->id,
                'name' => $team->name,
            ],
            'data'    => $reports,
        ]);
    }

    public function show(Request $request, Report $report): JsonResponse
    {
        $this->assertMyTeamTask($request, $report);

        $report->load([
            'region',
            'category',
            'images',
            'activeAssignment.team',
            'statusHistories',
        ]);

        return response()->json([
            'success' => true,
            'data'    => $report,
        ]);
    }

    public function accept(Request $request, Report $report): JsonResponse
    {
        $this->assertMyTeamTask($request, $report);

        $assignment = $report->activeAssignment;

        if (!$assignment) {
            throw ValidationException::withMessages([
                'report' => 'Laporan ini tidak punya assignment aktif.',
            ]);
        }

        $assignment = $this->assignmentService->accept($assignment, $request->user());

        return response()->json([
            'success' => true,
            'message' => 'Tugas diterima.',
            'data'    => [
                'assignment_id' => $assignment->id,
                'accepted_at'   => $assignment->accepted_at?->toIso8601String(),
            ],
        ]);
    }

    public function start(Request $request, Report $report): JsonResponse
    {
        $this->assertMyTeamTask($request, $report);

        $validated = $request->validate([
            'note' => 'nullable|string|max:500',
        ]);

        $report = $this->statusService->start(
            $report,
            $request->user(),
            $validated['note'] ?? null,
        );

        return response()->json([
            'success' => true,
            'message' => 'Status diubah ke sedang ditangani.',
            'data'    => [
                'id'     => $report->id,
                'status' => $report->status->value,
            ],
        ]);
    }

    public function complete(Request $request, Report $report): JsonResponse
    {
        $this->assertMyTeamTask($request, $report);

        $validated = $request->validate([
            'note' => 'nullable|string|max:500',
        ]);

        $report = $this->statusService->complete(
            $report,
            $request->user(),
            $validated['note'] ?? null,
        );

        return response()->json([
            'success' => true,
            'message' => 'Laporan selesai ditangani.',
            'data'    => [
                'id'     => $report->id,
                'status' => $report->status->value,
            ],
        ]);
    }

    private function assertMyTeamTask(Request $request, Report $report): void
    {
        $team = $request->user()->activeTeam();

        if (!$team) {
            throw ValidationException::withMessages([
                'team' => 'Anda belum tergabung dalam tim.',
            ]);
        }

        $active = $report->activeAssignment;

        if (!$active || $active->team_id !== $team->id || !$active->is_active) {
            throw ValidationException::withMessages([
                'report' => 'Laporan ini bukan tugas tim Anda.',
            ]);
        }
    }
}
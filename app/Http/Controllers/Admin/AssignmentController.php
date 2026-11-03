<?php

namespace App\Http\Controllers\Admin;

use App\Enums\ReportStatus;
use App\Http\Controllers\Controller;
use App\Models\Report;
use App\Models\Team;
use App\Services\AssignmentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AssignmentController extends Controller
{
    public function __construct(private AssignmentService $assignmentService) {}

    public function index(Request $request): JsonResponse
    {
        $reports = Report::query()
            ->where('status', ReportStatus::Verified)
            ->with(['region', 'category', 'activeAssignment.team'])
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
            'images',
            'activeAssignment.team',
            'assignments.team',
        ]);

        return response()->json([
            'success' => true,
            'data'    => [
                'report'           => $report,
                'available_teams'  => $this->assignmentService->availableTeamsForRegion($report->region_id),
            ],
        ]);
    }

    public function availableTeams(Report $report): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data'    => $this->assignmentService->availableTeamsForRegion($report->region_id),
        ]);
    }

    public function assign(Request $request, Report $report): JsonResponse
    {
        $validated = $request->validate([
            'team_id' => 'required|exists:teams,id',
            'note'    => 'nullable|string|max:500',
        ]);

        $team = Team::findOrFail($validated['team_id']);

        $assignment = $this->assignmentService->assign(
            $report,
            $team,
            $request->user(),
            $validated['note'] ?? null,
        );

        return response()->json([
            'success' => true,
            'message' => 'Laporan berhasil di-assign ke tim.',
            'data'    => [
                'assignment_id' => $assignment->id,
                'team'          => [
                    'id'   => $assignment->team->id,
                    'name' => $assignment->team->name,
                ],
                'report_status' => $report->fresh()->status->value,
            ],
        ]);
    }

    public function unassign(Request $request, Report $report): JsonResponse
    {
        $validated = $request->validate([
            'reason' => 'nullable|string|max:500',
        ]);

        $report = $this->assignmentService->unassign(
            $report,
            $request->user(),
            $validated['reason'] ?? null,
        );

        return response()->json([
            'success' => true,
            'message' => 'Penugasan dibatalkan. Laporan kembali ke status terverifikasi.',
            'data'    => [
                'id'     => $report->id,
                'status' => $report->status->value,
            ],
        ]);
    }
}
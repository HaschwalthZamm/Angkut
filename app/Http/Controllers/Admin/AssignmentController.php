<?php

namespace App\Http\Controllers\Admin;

use App\Enums\ReportStatus;
use App\Http\Controllers\Controller;
use App\Models\Report;
use App\Models\Team;
use App\Services\AssignmentService;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class AssignmentController extends Controller
{
    public function __construct(private AssignmentService $assignmentService) {}

    public function index(Request $request)
    {
        $reports = Report::query()
            ->where('status', ReportStatus::Verified)
            ->with(['region', 'category', 'user'])
            ->orderByDesc('created_at')
            ->paginate(10);

        $teams = Team::where('status', 'active')->with('region')->get();

        return view('admin.assignments.index', compact('reports', 'teams'));
    }

    public function show(Report $report)
    {
        $report->load(['region', 'category', 'images', 'activeAssignment.team', 'assignments.team']);
        return response()->json([
            'success' => true,
            'data'    => [
                'report' => $report,
                'available_teams' => $this->assignmentService->availableTeamsForRegion($report->region_id),
            ],
        ]);
    }

    public function availableTeams(Report $report)
    {
        return response()->json([
            'success' => true,
            'data'    => $this->assignmentService->availableTeamsForRegion($report->region_id),
        ]);
    }

    public function assign(Request $request, Report $report)
    {
        $validated = $request->validate([
            'team_id' => 'required|exists:teams,id',
            'note'    => 'nullable|string|max:500',
        ]);

        $team = Team::findOrFail($validated['team_id']);

        try {
            $this->assignmentService->assign(
                $report,
                $team,
                $request->user(),
                $validated['note'] ?? null
            );

            return back()->with('success', 'Laporan berhasil di-assign ke tim!');
        } catch (ValidationException $e) {
            return back()->withErrors($e->errors());
        }
    }

    public function unassign(Request $request, Report $report)
    {
        $validated = $request->validate([
            'reason' => 'nullable|string|max:500',
        ]);

        $this->assignmentService->unassign(
            $report,
            $request->user(),
            $validated['reason'] ?? null
        );

        return back()->with('success', 'Penugasan dibatalkan.');
    }
}
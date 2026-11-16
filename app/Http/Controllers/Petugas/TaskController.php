<?php

namespace App\Http\Controllers\Petugas;

use App\Enums\ReportStatus;
use App\Http\Controllers\Controller;
use App\Models\Report;
use App\Services\AssignmentService;
use App\Services\ReportStatusService;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class TaskController extends Controller
{
    public function __construct(
        private AssignmentService $assignmentService,
        private ReportStatusService $statusService,
    ) {}

    public function index(Request $request)
    {
        $team = $request->user()->activeTeam();

        if (!$team) {
            return view('petugas.tasks.index', [
                'team' => null,
                'reports' => collect(),
            ]);
        }

        $reports = Report::query()
            ->whereHas('activeAssignment', fn ($q) => $q->where('team_id', $team->id)->where('is_active', true))
            ->whereIn('status', [ReportStatus::Assigned, ReportStatus::OnProgress])
            ->with(['region', 'category', 'activeAssignment'])
            ->orderBy('sla_deadline_at', 'asc')
            ->paginate(10);

        return view('petugas.tasks.index', compact('team', 'reports'));
    }

    public function show(Request $request, Report $report)
    {
        $this->assertMyTeamTask($request, $report);

        $report->load([
            'region', 'category', 'images', 'activeAssignment.team', 'statusHistories',
        ]);

        return view('petugas.tasks.show', compact('report'));
    }

    public function accept(Request $request, Report $report)
    {
        $this->assertMyTeamTask($request, $report);
        $assignment = $report->activeAssignment;

        if (!$assignment) {
            throw ValidationException::withMessages(['report' => 'Laporan ini tidak punya assignment aktif.']);
        }

        $this->assignmentService->accept($assignment, $request->user());
        return back()->with('success', 'Tugas berhasil diterima. Silakan menuju lokasi.');
    }

    public function start(Request $request, Report $report)
    {
        $this->assertMyTeamTask($request, $report);

        $this->statusService->start($report, $request->user());
        return back()->with('success', 'Status diubah ke: Sedang Ditangani.');
    }

    public function complete(Request $request, Report $report)
    {
        $this->assertMyTeamTask($request, $report);

        $validated = $request->validate([
            'note' => 'nullable|string|max:500',
            'evidence_image' => 'required|image|mimes:jpeg,png,jpg,webp|max:5120',
        ]);

        // 1. Upload foto bukti
        if ($request->hasFile('evidence_image')) {
            $path = $request->file('evidence_image')->store('reports/' . $report->id . '/evidence', 'public');
            $report->images()->create([
                'type' => 'evidence',
                'path' => $path,
                'uploaded_by' => $request->user()->id,
                'caption' => 'Bukti penanganan oleh tim ' . $request->user()->activeTeam()?->name,
            ]);
        }

        // 2. Ubah status ke Completed
        $this->statusService->complete(
            $report,
            $request->user(),
            $validated['note'] ?? 'Sampah telah diangkut oleh tim.'
        );

        return redirect()->route('petugas.tasks.index')->with('success', 'Tugas berhasil diselesaikan! Terima kasih.');
    }

    private function assertMyTeamTask(Request $request, Report $report): void
    {
        $team = $request->user()->activeTeam();

        if (!$team) {
            throw ValidationException::withMessages(['team' => 'Anda belum tergabung dalam tim.']);
        }

        $active = $report->activeAssignment;

        if (!$active || $active->team_id !== $team->id || !$active->is_active) {
            throw ValidationException::withMessages(['report' => 'Laporan ini bukan tugas tim Anda.']);
        }
    }
}
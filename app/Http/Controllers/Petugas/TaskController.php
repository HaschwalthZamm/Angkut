<?php

namespace App\Http\Controllers\Petugas;

use App\Enums\ReportStatus;
use App\Http\Controllers\Controller;
use App\Models\Report;
use App\Services\AssignmentService;
use App\Services\ReportStatusService;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Carbon\Carbon;

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

    public function history(Request $request)
    {
        $team = $request->user()->activeTeam();

        if (!$team) {
            return view('petugas.tasks.history', [
                'team' => null,
                'reports' => collect(),
            ]);
        }

        // Ambil laporan yang sudah selesai atau ditutup oleh tim ini
        $reports = Report::query()
            ->whereHas('assignments', fn ($q) => $q->where('team_id', $team->id))
            ->whereIn('status', [ReportStatus::Completed, ReportStatus::Closed])
            ->with(['region', 'category'])
            ->orderByDesc('completed_at')
            ->paginate(10);

        return view('petugas.tasks.history', compact('team', 'reports'));
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

        if (!$assignment->accepted_at) {
            $assignment->update(['accepted_at' => Carbon::now()]);
        }

        return back()->with('success', 'Tugas berhasil diterima. Silakan menuju lokasi dan selesaikan tugas.');
    }

    public function complete(Request $request, Report $report)
    {
        $this->assertMyTeamTask($request, $report);

        if (!$report->activeAssignment->accepted_at) {
            return back()->withErrors(['error' => 'Anda harus menerima tugas ini terlebih dahulu sebelum menyelesaikannya.']);
        }

        $validated = $request->validate([
            'note' => 'nullable|string|max:500',
            'evidence_image' => 'required|image|mimes:jpeg,png,jpg,webp|max:5120',
        ]);

        if ($request->hasFile('evidence_image')) {
            $path = $request->file('evidence_image')->store('reports/' . $report->id . '/evidence', 'public');
            $report->images()->create([
                'type' => 'evidence',
                'path' => $path,
                'uploaded_by' => $request->user()->id,
                'caption' => 'Bukti penanganan oleh tim ' . $request->user()->activeTeam()?->name,
            ]);
        }

        if ($report->status === ReportStatus::Assigned) {
            $this->statusService->start($report, $request->user(), 'Petugas langsung menangani di lapangan.');
        }

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

        // Karena riwayat bisa diakses meski assignment sudah tidak aktif, cek apakah team pernah menangani
        $hasAccess = $report->assignments()->where('team_id', $team->id)->exists();

        if (!$hasAccess) {
            throw ValidationException::withMessages(['report' => 'Laporan ini bukan tugas tim Anda.']);
        }
    }
}
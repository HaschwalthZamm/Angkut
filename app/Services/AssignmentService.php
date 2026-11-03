<?php

namespace App\Services;

use App\Enums\ReportStatus;
use App\Enums\TeamStatus;
use App\Events\ReportAssigned;
use App\Models\Assignment;
use App\Models\Report;
use App\Models\Team;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class AssignmentService
{
    public function __construct(
        private ReportStatusService $statusService,
    ) {}

    /**
     * Assign laporan ke tim.
     */
    public function assign(Report $report, Team $team, User $admin, ?string $note = null): Assignment
    {
        // 1. Validasi status report
        if ($report->status !== ReportStatus::Verified) {
            throw ValidationException::withMessages([
                'report' => sprintf(
                    'Hanya laporan berstatus "Terverifikasi" yang bisa di-assign. Status sekarang: "%s".',
                    $report->status->label(),
                ),
            ]);
        }

        // 2. Validasi tim aktif
        if ($team->status !== TeamStatus::Active) {
            throw ValidationException::withMessages([
                'team_id' => sprintf(
                    'Tim "%s" tidak aktif (status: %s).',
                    $team->name,
                    $team->status->label(),
                ),
            ]);
        }

        // 3. Validasi region match
        if ($report->region_id !== $team->region_id) {
            throw ValidationException::withMessages([
                'team_id' => sprintf(
                    'Tim "%s" berada di wilayah berbeda dengan laporan. Tim: %s, Laporan: %s.',
                    $team->name,
                    $team->region?->name ?? $team->region_id,
                    $report->region?->name ?? $report->region_id,
                ),
            ]);
        }

        // 4. Eksekusi
        $assignment = DB::transaction(function () use ($report, $team, $admin, $note) {
            $existing = $report->activeAssignment;

            if ($existing) {
                if ($existing->team_id === $team->id) {
                    throw ValidationException::withMessages([
                        'team_id' => 'Laporan sudah di-assign ke tim ini.',
                    ]);
                }

                $this->deactivateAssignment($existing, 'Reassign ke tim lain oleh admin.');
            }

            $assignment = Assignment::create([
                'report_id'   => $report->id,
                'team_id'     => $team->id,
                'assigned_by' => $admin->id,
                'assigned_at' => Carbon::now(),
                'is_active'   => true,
                'note'        => $note,
            ]);

            $this->statusService->markAsAssigned(
                $report,
                $admin,
                $note ?? "Ditugaskan ke tim: {$team->name}.",
            );

            Log::info('Report assigned to team', [
                'report_id'     => $report->id,
                'tracking_code' => $report->tracking_code,
                'team_id'       => $team->id,
                'team_name'     => $team->name,
                'admin_id'      => $admin->id,
            ]);

            return $assignment->fresh(['team', 'report']);
        });

        // Fire event SETELAH commit
        ReportAssigned::dispatch($report->fresh(), $team, $admin);

        return $assignment;
    }

    /**
     * Batalkan assignment (unassign).
     */
    public function unassign(Report $report, User $admin, ?string $reason = null): Report
    {
        if (!$report->activeAssignment) {
            throw ValidationException::withMessages([
                'report' => 'Laporan ini belum di-assign ke tim manapun.',
            ]);
        }

        if ($report->status !== ReportStatus::Assigned) {
            throw ValidationException::withMessages([
                'report' => sprintf(
                    'Hanya laporan berstatus "Ditugaskan" yang bisa di-unassign. Status sekarang: "%s".',
                    $report->status->label(),
                ),
            ]);
        }

        return DB::transaction(function () use ($report, $admin, $reason) {
            $assignment = $report->activeAssignment;
            $this->deactivateAssignment($assignment, $reason ?? 'Unassign oleh admin.');

            $this->statusService->verify(
                $report,
                $admin,
                $reason ?? 'Penugasan dibatalkan, laporan dikembalikan ke status terverifikasi.',
            );

            Log::info('Report unassigned', [
                'report_id' => $report->id,
                'team_id'   => $assignment->team_id,
                'admin_id'  => $admin->id,
                'reason'    => $reason,
            ]);

            return $report->fresh();
        });
    }

    /**
     * Tandai assignment sebagai diterima oleh tim.
     */
    public function accept(Assignment $assignment, User $petugas): Assignment
    {
        if (!$assignment->is_active) {
            throw ValidationException::withMessages([
                'assignment' => 'Assignment ini sudah tidak aktif.',
            ]);
        }

        if ($assignment->accepted_at) {
            return $assignment;
        }

        $this->assertPetugasInTeam($petugas, $assignment->team_id);

        $assignment->update(['accepted_at' => Carbon::now()]);

        Log::info('Assignment accepted', [
            'assignment_id' => $assignment->id,
            'report_id'     => $assignment->report_id,
            'petugas_id'    => $petugas->id,
        ]);

        return $assignment->fresh();
    }

    /**
     * Ambil tim aktif di suatu wilayah.
     */
    public function availableTeamsForRegion(int $regionId)
    {
        return Team::where('region_id', $regionId)
            ->where('status', TeamStatus::Active)
            ->with(['leader', 'region'])
            ->withCount('activeMembers')
            ->orderBy('name')
            ->get();
    }

    // -----------------------------------------------------------------
    // Private helpers
    // -----------------------------------------------------------------

    private function deactivateAssignment(Assignment $assignment, ?string $note = null): void
    {
        $assignment->update([
            'is_active' => false,
            'note'      => $note ?? $assignment->note,
        ]);
    }

    private function assertPetugasInTeam(User $petugas, int $teamId): void
    {
        $isMember = $petugas->teamMemberships()
            ->where('team_id', $teamId)
            ->whereNull('left_at')
            ->exists();

        if (!$isMember) {
            throw ValidationException::withMessages([
                'petugas' => 'Petugas tidak tergabung dalam tim ini.',
            ]);
        }
    }
}
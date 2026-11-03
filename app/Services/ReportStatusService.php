<?php

namespace App\Services;

use App\Enums\ReportStatus;
use App\Events\ReportClosed;
use App\Events\ReportCompleted;
use App\Events\ReportRejected;
use App\Events\ReportStarted;
use App\Events\ReportVerified;
use App\Models\Report;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class ReportStatusService
{
    /**
     * Verifikasi laporan oleh admin. pending → verified.
     */
    public function verify(Report $report, User $admin, ?string $note = null): Report
    {
        return $this->transition(
            report: $report,
            newStatus: ReportStatus::Verified,
            actor: $admin,
            note: $note ?? 'Laporan diverifikasi oleh admin.',
            extraAttributes: [
                'verified_by' => $admin->id,
                'verified_at' => Carbon::now(),
            ],
        );
    }

    /**
     * Tolak laporan. pending|verified → rejected.
     */
    public function reject(Report $report, User $admin, string $reason): Report
    {
        if (trim($reason) === '') {
            throw ValidationException::withMessages([
                'rejected_reason' => 'Alasan penolakan wajib diisi.',
            ]);
        }

        return $this->transition(
            report: $report,
            newStatus: ReportStatus::Rejected,
            actor: $admin,
            note: 'Laporan ditolak: ' . $reason,
            extraAttributes: [
                'rejected_reason' => $reason,
                'verified_by'     => $admin->id,
                'verified_at'     => Carbon::now(),
            ],
        );
    }

    /**
     * Mulai penanganan oleh petugas. assigned → on_progress.
     */
    public function start(Report $report, User $petugas, ?string $note = null): Report
    {
        return $this->transition(
            report: $report,
            newStatus: ReportStatus::OnProgress,
            actor: $petugas,
            note: $note ?? 'Petugas mulai menangani laporan.',
        );
    }

    /**
     * Selesaikan laporan oleh petugas. on_progress → completed.
     */
    public function complete(Report $report, User $petugas, ?string $note = null): Report
    {
        return $this->transition(
            report: $report,
            newStatus: ReportStatus::Completed,
            actor: $petugas,
            note: $note ?? 'Laporan selesai ditangani.',
            extraAttributes: [
                'completed_at' => Carbon::now(),
            ],
        );
    }

    /**
     * Tutup laporan oleh admin. completed → closed.
     */
    public function close(Report $report, User $admin, ?string $note = null): Report
    {
        return $this->transition(
            report: $report,
            newStatus: ReportStatus::Closed,
            actor: $admin,
            note: $note ?? 'Laporan ditutup oleh admin.',
        );
    }

    /**
     * Helper untuk AssignmentService.
     */
    public function markAsAssigned(Report $report, User $admin, ?string $note = null): Report
    {
        return $this->transition(
            report: $report,
            newStatus: ReportStatus::Assigned,
            actor: $admin,
            note: $note ?? 'Laporan ditugaskan ke tim petugas.',
        );
    }

    // -----------------------------------------------------------------
    // Core transition
    // -----------------------------------------------------------------

    private function transition(
        Report $report,
        ReportStatus $newStatus,
        ?User $actor,
        ?string $note = null,
        array $extraAttributes = [],
    ): Report {
        $current = $report->status;

        // Idempotency
        if ($current === $newStatus) {
            return $report;
        }

        // Validasi transisi legal
        if (!$current->canTransitionTo($newStatus)) {
            throw ValidationException::withMessages([
                'status' => sprintf(
                    'Tidak bisa mengubah status dari "%s" ke "%s".',
                    $current->label(),
                    $newStatus->label(),
                ),
            ]);
        }

        // Eksekusi dalam transaction
        $result = DB::transaction(function () use (
            $report, $current, $newStatus, $actor, $note, $extraAttributes
        ) {
            $report->fill(array_merge($extraAttributes, [
                'status' => $newStatus,
            ]));
            $report->save();

            $report->statusHistories()->create([
                'status'     => $newStatus,
                'changed_by' => $actor?->id,
                'note'       => $note,
                'created_at' => Carbon::now(),
            ]);

            Log::info('Report status changed', [
                'report_id'  => $report->id,
                'from'       => $current->value,
                'to'         => $newStatus->value,
                'actor_id'   => $actor?->id,
                'actor_role' => $actor?->getRoleNames()->first(),
            ]);

            return $report->fresh();
        });

        // Fire event SETELAH transaction commit
        $this->dispatchTransitionEvent($result, $newStatus, $actor);

        return $result;
    }

    /**
     * Dispatch event sesuai status baru.
     */
    private function dispatchTransitionEvent(Report $report, ReportStatus $newStatus, ?User $actor): void
    {
        match ($newStatus) {
            ReportStatus::Verified   => ReportVerified::dispatch($report, $actor),
            ReportStatus::Rejected   => ReportRejected::dispatch($report, $actor, $report->rejected_reason ?? ''),
            ReportStatus::OnProgress => ReportStarted::dispatch($report, $actor),
            ReportStatus::Completed  => ReportCompleted::dispatch($report, $actor),
            ReportStatus::Closed     => ReportClosed::dispatch($report, $actor),
            // Assigned di-handle AssignmentService, supaya tidak dobel
            ReportStatus::Assigned,
            ReportStatus::Pending    => null,
        };
    }
}
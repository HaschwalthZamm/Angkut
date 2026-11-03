<?php

namespace App\Services;

use App\Enums\ReportStatus;
use App\Models\Report;
use Carbon\CarbonInterface;
use Illuminate\Support\Collection;

class SlaService
{
    public function dueAt(ReportStatus $status, ?CarbonInterface $from = null): CarbonInterface
    {
        $from ??= now();

        $hours = match ($status) {
            ReportStatus::Pending => (int) config('angkut.sla.pending_hours', 24),
            ReportStatus::Verified, ReportStatus::Assigned, ReportStatus::OnProgress => (int) config('angkut.sla.verified_hours', 12),
            default => (int) config('angkut.sla.pending_hours', 24),
        };

        return $from->copy()->addHours($hours);
    }

    /**
     * @return Collection<int, Report>
     */
    public function overdueReports(): Collection
    {
        return Report::query()
            ->whereNotNull('sla_due_at')
            ->where('sla_due_at', '<', now())
            ->whereNotIn('status', [
                ReportStatus::Completed->value,
                ReportStatus::Rejected->value,
                ReportStatus::Closed->value,
            ])
            ->get();
    }
}

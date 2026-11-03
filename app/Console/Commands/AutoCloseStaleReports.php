<?php

namespace App\Console\Commands;

use App\Enums\ReportStatus;
use App\Models\Report;
use App\Services\ReportStatusService;
use Illuminate\Console\Command;

class AutoCloseStaleReports extends Command
{
    protected $signature = 'angkut:auto-close-stale {--days= : Override TTL hari}';

    protected $description = 'Tutup laporan selesai/ditolak yang melewati masa simpan tracking.';

    public function handle(ReportStatusService $statusService): int
    {
        $days = (int) ($this->option('days') ?: config('angkut.tracking.ttl_days', 30));

        $reports = Report::query()
            ->whereIn('status', [ReportStatus::Completed->value, ReportStatus::Rejected->value])
            ->where('updated_at', '<', now()->subDays($days))
            ->get();

        foreach ($reports as $report) {
            $statusService->transition($report, ReportStatus::Closed, null, 'Ditutup otomatis');
        }

        $this->info("Ditutup: {$reports->count()} laporan.");

        return self::SUCCESS;
    }
}

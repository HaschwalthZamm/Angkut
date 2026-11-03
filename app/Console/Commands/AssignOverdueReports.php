<?php

namespace App\Console\Commands;

use App\Services\SlaService;
use Illuminate\Console\Command;

class AssignOverdueReports extends Command
{
    protected $signature = 'angkut:assign-overdue';

    protected $description = 'Tandai dan catat laporan yang melewati SLA untuk ditindaklanjuti admin.';

    public function handle(SlaService $slaService): int
    {
        $overdue = $slaService->overdueReports();

        foreach ($overdue as $report) {
            activity()
                ->performedOn($report)
                ->withProperties(['sla_due_at' => $report->sla_due_at])
                ->log("Laporan {$report->tracking_code} melewati SLA");
        }

        $this->info("Laporan lewat SLA: {$overdue->count()}.");

        return self::SUCCESS;
    }
}

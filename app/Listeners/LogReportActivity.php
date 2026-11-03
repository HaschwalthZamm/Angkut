<?php

namespace App\Listeners;

use App\Events\ReportAssignedToTeam;
use App\Events\ReportCompleted;
use App\Events\ReportCreated;
use App\Events\ReportInProgress;
use App\Events\ReportRejected;
use App\Events\ReportVerified;
use App\Models\Report;

class LogReportActivity
{
    public function handle(
        ReportCreated|ReportVerified|ReportRejected|ReportAssignedToTeam|ReportInProgress|ReportCompleted $event
    ): void {
        $report = $event->report;

        activity()
            ->performedOn($report)
            ->causedBy(auth()->user())
            ->withProperties([
                'tracking_code' => $report->tracking_code,
                'status' => $report->status->value,
            ])
            ->log($this->description($event, $report));
    }

    private function description(object $event, Report $report): string
    {
        return match ($event::class) {
            ReportCreated::class => "Laporan {$report->tracking_code} dibuat",
            ReportVerified::class => "Laporan {$report->tracking_code} diverifikasi",
            ReportRejected::class => "Laporan {$report->tracking_code} ditolak",
            ReportAssignedToTeam::class => "Laporan {$report->tracking_code} ditugaskan ke tim",
            ReportInProgress::class => "Laporan {$report->tracking_code} dikerjakan",
            ReportCompleted::class => "Laporan {$report->tracking_code} selesai",
            default => "Aktivitas laporan {$report->tracking_code}",
        };
    }
}

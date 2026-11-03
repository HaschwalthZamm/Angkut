<?php

namespace App\Listeners;

use App\Events\ReportRejected;
use App\Notifications\ReportRejectedNotification;
use Illuminate\Support\Facades\Log;

class NotifyReporterOnRejected
{
    public function handle(ReportRejected $event): void
    {
        $reporter = $event->report->user;

        if (!$reporter) {
            Log::info('Report rejected, guest reporter - no DB notification', [
                'report_id' => $event->report->id,
                'reason'    => $event->reason,
            ]);
            return;
        }

        $reporter->notify(new ReportRejectedNotification($event->report, $event->reason));
    }
}
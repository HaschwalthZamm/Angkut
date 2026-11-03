<?php

namespace App\Listeners;

use App\Events\ReportClosed;
use App\Notifications\ReportClosedNotification;
use Illuminate\Support\Facades\Log;

class NotifyReporterOnClosed
{
    public function handle(ReportClosed $event): void
    {
        $reporter = $event->report->user;

        if (!$reporter) {
            Log::info('Report closed, guest reporter - no DB notification', [
                'report_id' => $event->report->id,
            ]);
            return;
        }

        $reporter->notify(new ReportClosedNotification($event->report));
    }
}
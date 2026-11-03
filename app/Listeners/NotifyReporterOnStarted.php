<?php

namespace App\Listeners;

use App\Events\ReportStarted;
use App\Notifications\ReportStartedNotification;
use Illuminate\Support\Facades\Log;

class NotifyReporterOnStarted
{
    public function handle(ReportStarted $event): void
    {
        $reporter = $event->report->user;

        if (!$reporter) {
            Log::info('Report started, guest reporter - no DB notification', [
                'report_id' => $event->report->id,
            ]);
            return;
        }

        $reporter->notify(new ReportStartedNotification($event->report));
    }
}
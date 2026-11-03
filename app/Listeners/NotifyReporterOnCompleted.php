<?php

namespace App\Listeners;

use App\Events\ReportCompleted;
use App\Notifications\ReportCompletedNotification;
use Illuminate\Support\Facades\Log;

class NotifyReporterOnCompleted
{
    public function handle(ReportCompleted $event): void
    {
        $reporter = $event->report->user;

        if (!$reporter) {
            Log::info('Report completed, guest reporter - no DB notification', [
                'report_id' => $event->report->id,
            ]);
            return;
        }

        $reporter->notify(new ReportCompletedNotification($event->report));
    }
}
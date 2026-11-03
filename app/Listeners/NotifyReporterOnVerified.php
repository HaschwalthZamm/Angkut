<?php

namespace App\Listeners;

use App\Events\ReportVerified;
use App\Notifications\ReportVerifiedNotification;
use Illuminate\Support\Facades\Log;

class NotifyReporterOnVerified
{
    public function handle(ReportVerified $event): void
    {
        $reporter = $event->report->user;

        if (!$reporter) {
            Log::info('Report verified, guest reporter - no DB notification', [
                'report_id' => $event->report->id,
            ]);
            return;
        }

        $reporter->notify(new ReportVerifiedNotification($event->report));
    }
}
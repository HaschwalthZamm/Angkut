<?php

namespace App\Listeners;

use App\Events\ReportCreated;
use App\Models\User;
use App\Notifications\NewReportForAdminNotification;
use Illuminate\Support\Facades\Log;

class NotifyAdminsOnNewReport
{
    public function handle(ReportCreated $event): void
    {
        $admins = User::role('admin')->get();

        foreach ($admins as $admin) {
            $admin->notify(new NewReportForAdminNotification($event->report));
        }

        if ($event->report->user_id === null) {
            Log::info('Guest report created, WA notification pending for fase 2', [
                'report_id' => $event->report->id,
                'phone'     => $event->report->reporter_phone,
            ]);
        }
    }
}
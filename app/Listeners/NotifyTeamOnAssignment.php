<?php

namespace App\Listeners;

use App\Events\ReportAssigned;
use App\Notifications\ReportAssignedNotification;
use Illuminate\Support\Facades\Log;

class NotifyTeamOnAssigned
{
    public function handle(ReportAssigned $event): void
    {
        $members = $event->team->activeMembers()->with('user')->get();

        foreach ($members as $member) {
            if (!$member->user) {
                continue;
            }

            $member->user->notify(
                new ReportAssignedNotification($event->report, $event->team)
            );
        }

        Log::info('Report assigned, team notified', [
            'report_id'      => $event->report->id,
            'team_id'        => $event->team->id,
            'member_count'   => $members->count(),
        ]);
    }
}
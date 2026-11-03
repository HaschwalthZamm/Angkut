<?php

namespace App\Listeners;

use App\Enums\NotificationChannel;
use App\Events\ReportCompleted;
use App\Events\ReportCreated;
use App\Events\ReportRejected;
use App\Events\ReportVerified;
use App\Notifications\ReportCompletedNotification;
use App\Notifications\ReportRejectedNotification;
use App\Notifications\ReportSubmittedNotification;
use App\Notifications\ReportVerifiedNotification;
use App\Services\Notification\NotificationService;

class NotifyReporterOnStatusChange
{
    public function __construct(private NotificationService $notifications) {}

    public function handle(ReportCreated|ReportVerified|ReportRejected|ReportCompleted $event): void
    {
        $user = $event->report->reporter;

        if (! $user) {
            return;
        }

        $notification = match ($event::class) {
            ReportCreated::class => new ReportSubmittedNotification($event->report),
            ReportVerified::class => new ReportVerifiedNotification($event->report),
            ReportRejected::class => new ReportRejectedNotification($event->report),
            ReportCompleted::class => new ReportCompletedNotification($event->report),
        };

        $this->notifications->notify($user, [
            'type' => class_basename($notification),
            'title' => $notification->toArray($user)['title'] ?? 'Update laporan',
            'body' => $notification->toArray($user)['body'] ?? '',
            'data' => ['report_id' => $event->report->id],
            'notification' => $notification,
        ], [NotificationChannel::Database, NotificationChannel::Email]);
    }
}

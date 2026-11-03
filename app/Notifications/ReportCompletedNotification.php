<?php

namespace App\Notifications;

use App\Models\Report;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ReportCompletedNotification extends Notification
{
    use Queueable;

    public function __construct(public Report $report) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'type'          => 'report_completed',
            'report_id'     => $this->report->id,
            'tracking_code' => $this->report->tracking_code,
            'title'         => $this->report->title,
            'message'       => "Laporan Anda \"{$this->report->title}\" telah selesai ditangani. Mohon beri feedback.",
            'url'           => "/laporan/{$this->report->tracking_code}",
        ];
    }
}
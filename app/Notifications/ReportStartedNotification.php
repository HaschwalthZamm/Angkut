<?php

namespace App\Notifications;

use App\Models\Report;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ReportStartedNotification extends Notification
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
            'type'          => 'report_started',
            'report_id'     => $this->report->id,
            'tracking_code' => $this->report->tracking_code,
            'title'         => $this->report->title,
            'message'       => "Petugas sedang menangani laporan Anda \"{$this->report->title}\".",
            'url'           => "/laporan/{$this->report->tracking_code}",
        ];
    }
}
<?php

namespace App\Notifications;

use App\Models\Report;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ReportRejectedNotification extends Notification
{
    use Queueable;

    public function __construct(
        public Report $report,
        public string $reason,
    ) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'type'          => 'report_rejected',
            'report_id'     => $this->report->id,
            'tracking_code' => $this->report->tracking_code,
            'title'         => $this->report->title,
            'reason'        => $this->reason,
            'message'       => "Laporan Anda \"{$this->report->title}\" ditolak. Alasan: {$this->reason}",
            'url'           => "/laporan/{$this->report->tracking_code}",
        ];
    }
}
<?php

namespace App\Notifications;

use App\Models\Report;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NewReportForAdminNotification extends Notification
{
    use Queueable;

    public function __construct(public Report $report) {}

    public function via(object $notifiable): array
    {
        // Nanti tinggal tambah 'mail' setelah SMTP siap
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'type'          => 'report_created',
            'report_id'     => $this->report->id,
            'tracking_code' => $this->report->tracking_code,
            'title'         => $this->report->title,
            'priority'      => $this->report->priority->value,
            'region'        => $this->report->region?->name,
            'message'       => "Laporan baru masuk: \"{$this->report->title}\" ({$this->report->tracking_code})",
            'url'           => "/admin/reports/{$this->report->id}",
        ];
    }
}
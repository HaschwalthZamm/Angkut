<?php

namespace App\Notifications;

use App\Models\Report;
use App\Models\Team;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ReportAssignedNotification extends Notification
{
    use Queueable;

    public function __construct(
        public Report $report,
        public Team $team,
    ) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'type'          => 'report_assigned',
            'report_id'     => $this->report->id,
            'tracking_code' => $this->report->tracking_code,
            'title'         => $this->report->title,
            'team_id'       => $this->team->id,
            'team_name'     => $this->team->name,
            'priority'      => $this->report->priority->value,
            'address'       => $this->report->address,
            'latitude'      => (float) $this->report->latitude,
            'longitude'     => (float) $this->report->longitude,
            'message'       => "Tugas baru untuk tim {$this->team->name}: \"{$this->report->title}\"",
            'url'           => "/petugas/tasks/{$this->report->id}",
        ];
    }
}
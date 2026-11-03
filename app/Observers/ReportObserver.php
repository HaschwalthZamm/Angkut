<?php

namespace App\Observers;

use App\Models\Report;

class ReportObserver
{
    public function created(Report $report): void
    {
        $report->statusHistories()->create([
            'from_status' => null,
            'to_status' => $report->status,
            'user_id' => auth()->id(),
            'notes' => 'Laporan dibuat',
        ]);
    }

    public function updating(Report $report): void
    {
        if (! $report->isDirty('status')) {
            return;
        }

        $report->statusHistories()->create([
            'from_status' => $report->getOriginal('status'),
            'to_status' => $report->status,
            'user_id' => auth()->id(),
        ]);
    }
}

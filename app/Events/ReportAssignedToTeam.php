<?php

namespace App\Events;

use App\Models\Assignment;
use App\Models\Report;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ReportAssignedToTeam
{
    use Dispatchable, SerializesModels;

    public function __construct(
        public Report $report,
        public Assignment $assignment,
    ) {}
}

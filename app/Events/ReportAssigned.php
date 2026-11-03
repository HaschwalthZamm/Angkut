<?php

namespace App\Events;

use App\Models\Report;
use App\Models\Team;
use App\Models\User;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ReportAssigned
{
    use Dispatchable, SerializesModels;

    public function __construct(
        public Report $report,
        public Team $team,
        public ?User $actor,
    ) {}
}
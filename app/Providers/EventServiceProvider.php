<?php

namespace App\Providers;

use App\Events\ReportAssigned;
use App\Events\ReportClosed;
use App\Events\ReportCompleted;
use App\Events\ReportCreated;
use App\Events\ReportRejected;
use App\Events\ReportStarted;
use App\Events\ReportVerified;
use App\Listeners\NotifyAdminsOnNewReport;
use App\Listeners\NotifyReporterOnClosed;
use App\Listeners\NotifyReporterOnCompleted;
use App\Listeners\NotifyReporterOnRejected;
use App\Listeners\NotifyReporterOnStarted;
use App\Listeners\NotifyReporterOnVerified;
use App\Listeners\NotifyTeamOnAssigned;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        ReportCreated::class   => [NotifyAdminsOnNewReport::class],
        ReportVerified::class  => [NotifyReporterOnVerified::class],
        ReportRejected::class  => [NotifyReporterOnRejected::class],
        ReportAssigned::class  => [NotifyTeamOnAssigned::class],
        ReportStarted::class   => [NotifyReporterOnStarted::class],
        ReportCompleted::class => [NotifyReporterOnCompleted::class],
        ReportClosed::class    => [NotifyReporterOnClosed::class],
    ];
}
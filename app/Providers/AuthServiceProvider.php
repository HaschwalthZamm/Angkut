<?php

namespace App\Providers;

use App\Models\Assignment;
use App\Models\Report;
use App\Models\Team;
use App\Models\User;
use App\Policies\AssignmentPolicy;
use App\Policies\ReportPolicy;
use App\Policies\TeamPolicy;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Report::class => ReportPolicy::class,
        Assignment::class => AssignmentPolicy::class,
        Team::class => TeamPolicy::class,
        User::class => UserPolicy::class,
    ];
}

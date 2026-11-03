<?php

namespace App\Support;

use App\Enums\ReportPriority;
use App\Enums\ReportStatus;
use App\Enums\TeamStatus;

class StatusBadge
{
    public static function report(ReportStatus $status): string
    {
        return match ($status) {
            ReportStatus::Pending => 'bg-amber-100 text-amber-800',
            ReportStatus::Verified => 'bg-sky-100 text-sky-800',
            ReportStatus::Assigned => 'bg-indigo-100 text-indigo-800',
            ReportStatus::OnProgress => 'bg-blue-100 text-blue-800',
            ReportStatus::Completed => 'bg-emerald-100 text-emerald-800',
            ReportStatus::Rejected => 'bg-rose-100 text-rose-800',
            ReportStatus::Closed => 'bg-slate-100 text-slate-700',
        };
    }

    public static function priority(ReportPriority $priority): string
    {
        return match ($priority) {
            ReportPriority::Low => 'bg-slate-100 text-slate-700',
            ReportPriority::Medium => 'bg-amber-100 text-amber-800',
            ReportPriority::High => 'bg-orange-100 text-orange-800',
            ReportPriority::Urgent => 'bg-rose-100 text-rose-800',
        };
    }

    public static function team(TeamStatus $status): string
    {
        return match ($status) {
            TeamStatus::Active => 'bg-emerald-100 text-emerald-800',
            TeamStatus::Inactive => 'bg-slate-100 text-slate-700',
            TeamStatus::Suspended => 'bg-rose-100 text-rose-800',
        };
    }
}

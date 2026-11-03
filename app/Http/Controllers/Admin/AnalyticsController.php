<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Report;
use App\Models\Region;
use Illuminate\View\View;

class AnalyticsController extends Controller
{
    public function __invoke(): View
    {
        $byRegion = Region::query()
            ->withCount('reports')
            ->orderByDesc('reports_count')
            ->get();

        $byStatus = Report::query()
            ->selectRaw('status, count(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        return view('admin.analytics', compact('byRegion', 'byStatus'));
    }
}

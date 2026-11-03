<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Http\Requests\Report\StoreReportRequest;
use App\Models\Region;
use App\Models\ReportCategory;
use App\Services\ReportService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class LandingController extends Controller
{
    public function __invoke(): View
    {
        return view('public.landing', [
            'regions' => Region::query()->where('is_active', true)->orderBy('name')->get(),
            'categories' => ReportCategory::query()->where('is_active', true)->orderBy('name')->get(),
        ]);
    }

    public function store(StoreReportRequest $request, ReportService $reportService): RedirectResponse
    {
        $report = $reportService->create(
            $request->validated(),
            $request->file('images', []),
            $request->user(),
        );

        return redirect()
            ->route('tracking.create')
            ->with('status', "Laporan tercatat. Kode tracking: {$report->tracking_code}");
    }
}

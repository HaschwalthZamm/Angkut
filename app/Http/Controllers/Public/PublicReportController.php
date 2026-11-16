<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Region;
use App\Models\ReportCategory;
use App\Services\ReportService;
use Illuminate\Http\Request;

class PublicReportController extends Controller
{
    public function __construct(private ReportService $reportService) {}

    public function create()
    {
        $regions = Region::where('is_active', true)->orderBy('name')->get();
        $categories = ReportCategory::where('is_active', true)->orderBy('name')->get();

        return view('reports.create', [
            'regions' => $regions,
            'categories' => $categories,
            'isGuest' => true,
            'actionUrl' => route('public.report.store'),
        ]);
    }

    public function store(Request $request)
    {
        $rules = [
            'region_id'          => 'required|exists:regions,id',
            'report_category_id' => 'required|exists:report_categories,id',
            'title'              => 'required|string|max:150',
            'description'        => 'required|string|max:2000',
            'latitude'           => 'required|numeric|between:-90,90',
            'longitude'          => 'required|numeric|between:-180,180',
            'address'            => 'nullable|string|max:255',
            'priority'           => 'nullable|in:low,medium,high,urgent',
            'images.*'           => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
        ];

        $rules['reporter_name'] = 'required|string|max:100';
        $rules['reporter_phone'] = 'required|string|max:20';

        $validated = $request->validate($rules);

        if ($request->hasFile('images')) {
            $validated['images'] = $request->file('images');
        }

        $report = $this->reportService->createReport($validated, null);

        // PERBAIKAN: Hanya bawa parameter phone
        return redirect()->route('public.tracking.create', [
            'phone' => $report->reporter_phone
        ])->with('success', 'Laporan berhasil dibuat!');
    }
}
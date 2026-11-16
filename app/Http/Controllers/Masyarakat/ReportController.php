<?php

namespace App\Http\Controllers\Masyarakat;

use App\Http\Controllers\Controller;
use App\Models\Region;
use App\Models\Report;
use App\Models\ReportCategory;
use App\Services\ReportService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ReportController extends Controller
{
    public function __construct(private ReportService $reportService) {}

    public function index(Request $request)
    {
        $reports = Report::query()
            ->where('user_id', $request->user()->id)
            ->with(['region', 'category', 'activeAssignment.team'])
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('masyarakat.reports.index', compact('reports'));
    }

    public function create()
    {
        $regions = Region::where('is_active', true)->orderBy('name')->get();
        $categories = ReportCategory::where('is_active', true)->orderBy('name')->get();

        // Kita gunakan view yang sama dengan guest, tapi dengan flag $isGuest = false
        return view('reports.create', [
            'regions' => $regions,
            'categories' => $categories,
            'isGuest' => false,
            'actionUrl' => route('masyarakat.reports.store'),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'region_id'          => 'required|exists:regions,id',
            'report_category_id' => 'required|exists:report_categories,id',
            'title'              => 'required|string|max:150',
            'description'        => 'required|string|max:2000',
            'latitude'           => 'required|numeric|between:-90,90',
            'longitude'          => 'required|numeric|between:-180,180',
            'address'            => 'nullable|string|max:255',
            'priority'           => 'nullable|in:low,medium,high,urgent',
            'images.*'           => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120', // Maks 5MB per foto
        ]);

        // Handle Upload Foto
        if ($request->hasFile('images')) {
            $validated['images'] = $request->file('images');
        }

        // Panggil Service (user otomatis terdeteksi dari Auth)
        $report = $this->reportService->createReport($validated, $request->user());

        return redirect()->route('masyarakat.reports.show', $report->id)
            ->with('success', 'Laporan berhasil dibuat! Kode Tracking: ' . $report->tracking_code);
    }

    public function show(Request $request, Report $report)
    {
        if ($report->user_id !== $request->user()->id) {
            abort(403, 'Anda tidak berhak melihat laporan ini.');
        }

        $report->load([
            'region', 'category', 'images', 'statusHistories',
            'activeAssignment.team', 'feedback',
        ]);

        return view('masyarakat.reports.show', compact('report'));
    }
}
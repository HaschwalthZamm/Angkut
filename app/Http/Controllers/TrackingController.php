<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Report;
use App\Services\ReportService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TrackingController extends Controller
{
    public function __construct(private ReportService $reportService) {}

    public function create(Request $request)
    {
        $phone = $request->query('phone');
        $reports = collect();

        if ($phone) {
            $reports = $this->reportService->trackReportsByPhone($phone);
        }

        return view('public.tracking', compact('reports', 'phone'));
    }

    public function track(Request $request)
    {
        $validated = $request->validate([
            'phone' => 'required|string|max:20',
        ]);

        $reports = $this->reportService->trackReportsByPhone($validated['phone']);

        if ($reports->isEmpty()) {
            return back()->withErrors(['phone' => 'Tidak ada laporan yang ditemukan dengan nomor HP tersebut.'])->withInput();
        }

        return view('public.tracking', [
            'reports' => $reports,
            'phone' => $validated['phone']
        ]);
    }

    /**
     * Menampilkan detail laporan via tautan notifikasi (/laporan/{code})
     */
    public function show($tracking_code)
    {
        $report = Report::where('tracking_code', $tracking_code)
            ->with([
                'region', 'category', 'images', 'statusHistories', 
                'feedback', 'activeAssignment.team'
            ])
            ->firstOrFail();

        // Jika user sudah login dan ini laporannya, arahkan ke dashboard masyarakat
        // agar bisa langsung memberi feedback di sana
        if (Auth::check() && $report->user_id === Auth::id()) {
            return redirect()->route('masyarakat.reports.show', $report->id);
        }

        // Jika guest (belum login) atau bukan pemilik laporan, tampilkan halaman publik
        return view('public.report_detail', compact('report'));
    }
}
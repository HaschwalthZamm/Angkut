<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Services\ReportService;
use Illuminate\Http\Request;

class TrackingController extends Controller
{
    public function __construct(private ReportService $reportService) {}

    public function create(Request $request)
    {
        // Jika diarahkan dari form lapor sukses
        $phone = $request->query('phone');
        $reports = collect(); // Default kosong

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
}
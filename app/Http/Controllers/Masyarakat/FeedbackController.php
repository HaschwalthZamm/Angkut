<?php

namespace App\Http\Controllers\Masyarakat;

use App\Enums\ReportStatus;
use App\Http\Controllers\Controller;
use App\Models\Report;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    public function store(Request $request, Report $report)
    {
        // 1. Pastikan laporan ini milik user yang login
        if ($report->user_id !== $request->user()->id) {
            abort(403, 'Anda tidak berhak memberi feedback pada laporan ini.');
        }

        // 2. Pastikan laporan sudah selesai (completed)
        if ($report->status !== ReportStatus::Completed) {
            return back()->withErrors(['feedback' => 'Anda hanya bisa memberi feedback jika laporan sudah selesai.']);
        }

        // 3. Pastikan belum pernah memberi feedback
        if ($report->feedback) {
            return back()->withErrors(['feedback' => 'Anda sudah memberikan feedback untuk laporan ini.']);
        }

        // 4. Validasi input
        $validated = $request->validate([
            'rating' => 'required|integer|between:1,5',
            'comment' => 'nullable|string|max:1000',
        ]);

        // 5. Simpan feedback
        $report->feedback()->create([
            'user_id' => $request->user()->id,
            'rating'  => $validated['rating'],
            'comment' => $validated['comment'] ?? null,
        ]);

        return back()->with('success', 'Terima kasih atas penilaian Anda!');
    }
}
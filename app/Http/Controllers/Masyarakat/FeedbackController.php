<?php

namespace App\Http\Controllers\Masyarakat;

use App\Enums\ReportStatus;
use App\Http\Controllers\Controller;
use App\Models\Report;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    public function store(Request $request, Report $report): RedirectResponse
    {
        $this->authorize('view', $report);
        abort_unless($report->status === ReportStatus::Completed, 422);

        $data = $request->validate([
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'comment' => ['nullable', 'string', 'max:1000'],
        ]);

        $report->feedback()->updateOrCreate(
            ['report_id' => $report->id],
            [
                'user_id' => $request->user()->id,
                'rating' => $data['rating'],
                'comment' => $data['comment'] ?? null,
            ],
        );

        return back()->with('status', 'Terima kasih atas penilaiannya.');
    }
}

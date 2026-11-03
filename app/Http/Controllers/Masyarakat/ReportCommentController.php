<?php

namespace App\Http\Controllers\Masyarakat;

use App\Http\Controllers\Controller;
use App\Models\Report;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ReportCommentController extends Controller
{
    public function store(Request $request, Report $report): RedirectResponse
    {
        $this->authorize('view', $report);

        $data = $request->validate([
            'body' => ['required', 'string', 'max:2000'],
        ]);

        $report->comments()->create([
            'user_id' => $request->user()->id,
            'body' => $data['body'],
        ]);

        return back()->with('status', 'Komentar terkirim.');
    }
}

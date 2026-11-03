<?php

namespace App\Http\Controllers\Petugas;

use App\Enums\ReportStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Task\UpdateTaskStatusRequest;
use App\Models\Report;
use App\Services\ImageUploadService;
use App\Services\ReportStatusService;
use Illuminate\Http\RedirectResponse;

class TaskStatusController extends Controller
{
    public function update(
        UpdateTaskStatusRequest $request,
        Report $report,
        ReportStatusService $statusService,
        ImageUploadService $imageUploadService,
    ): RedirectResponse {
        $status = ReportStatus::from($request->string('status')->toString());
        $statusService->transition($report, $status, $request->user(), $request->input('notes'));

        foreach ($request->file('images', []) as $image) {
            $path = $imageUploadService->store($image, 'reports/'.$report->id);
            $report->images()->create([
                'path' => $path,
                'kind' => $status === ReportStatus::Completed ? 'after' : 'progress',
                'original_name' => $image->getClientOriginalName(),
            ]);
        }

        if ($status === ReportStatus::OnProgress && $report->latestAssignment) {
            $report->latestAssignment->update(['started_at' => now()]);
        }

        if ($status === ReportStatus::Completed && $report->latestAssignment) {
            $report->latestAssignment->update(['completed_at' => now()]);
        }

        return back()->with('status', 'Status tugas diperbarui.');
    }
}

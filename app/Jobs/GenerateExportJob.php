<?php

namespace App\Jobs;

use App\Models\Report;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Storage;

class GenerateExportJob implements ShouldQueue
{
    use Queueable;

    public function __construct(public string $filename = 'reports.pdf') {}

    public function handle(): void
    {
        $reports = Report::query()->with(['region', 'category'])->latest()->limit(200)->get();

        $pdf = Pdf::loadView('admin.exports.reports', ['reports' => $reports]);

        Storage::disk('local')->put('private/exports/'.$this->filename, $pdf->output());
    }
}

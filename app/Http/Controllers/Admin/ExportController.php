<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\GenerateExportJob;
use Illuminate\Http\RedirectResponse;

class ExportController extends Controller
{
    public function __invoke(): RedirectResponse
    {
        $filename = 'reports-'.now()->format('Ymd-His').'.pdf';
        GenerateExportJob::dispatch($filename);

        return back()->with('status', 'Export sedang diproses: '.$filename);
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Report;
use Illuminate\Http\Request;

class VerificationController extends Controller
{
    public function index()
    {
        // Ambil data laporan yang butuh verifikasi (status pending)
        $reports = Report::with(['category', 'user', 'region'])
            ->where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // KEMBALIKAN KE VIEW, BUKAN JSON
        return view('admin.verifications.index', compact('reports'));
    }

    public function show($id)
    {
        // Tampilkan detail laporan untuk diverifikasi
        $report = Report::with(['category', 'user', 'region', 'photos'])->findOrFail($id);
        
        return view('admin.verifications.show', compact('report'));
    }
}
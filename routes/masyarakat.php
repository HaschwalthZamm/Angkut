<?php

use App\Http\Controllers\Masyarakat\DashboardController;
use App\Http\Controllers\Masyarakat\FeedbackController;
use App\Http\Controllers\Masyarakat\ReportController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'role:masyarakat'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/create', [ReportController::class, 'create'])->name('reports.create');
    Route::post('/reports', [ReportController::class, 'store'])->name('reports.store');
    Route::get('/reports/{report}', [ReportController::class, 'show'])->name('reports.show');
    
    // Route untuk Feedback
    Route::post('/reports/{report}/feedback', [FeedbackController::class, 'store'])->name('reports.feedback');
});
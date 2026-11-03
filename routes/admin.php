<?php

use App\Http\Controllers\Admin\AssignmentController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\VerificationController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'role:admin'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Verifikasi laporan
    Route::get('/verifications', [VerificationController::class, 'index'])->name('verifications.index');
    Route::get('/verifications/{report}', [VerificationController::class, 'show'])->name('verifications.show');
    Route::post('/verifications/{report}/verify', [VerificationController::class, 'verify'])->name('verifications.verify');
    Route::post('/verifications/{report}/reject', [VerificationController::class, 'reject'])->name('verifications.reject');

    // Assignment
    Route::get('/assignments', [AssignmentController::class, 'index'])->name('assignments.index');
    Route::get('/assignments/{report}', [AssignmentController::class, 'show'])->name('assignments.show');
    Route::get('/assignments/{report}/teams', [AssignmentController::class, 'availableTeams'])->name('assignments.teams');
    Route::post('/assignments/{report}', [AssignmentController::class, 'assign'])->name('assignments.assign');
    Route::delete('/assignments/{report}', [AssignmentController::class, 'unassign'])->name('assignments.unassign');

    // Semua laporan
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/{report}', [ReportController::class, 'show'])->name('reports.show');
    Route::post('/reports/{report}/close', [ReportController::class, 'close'])->name('reports.close');
});
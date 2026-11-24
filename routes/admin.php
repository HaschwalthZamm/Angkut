<?php

use App\Http\Controllers\Admin\AssignmentController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PetugasController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\TeamController;
use App\Http\Controllers\Admin\VerificationController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Verifikasi
    Route::get('/verifications', [VerificationController::class, 'index'])->name('verifications.index');
    Route::get('/verifications/{report}', [VerificationController::class, 'show'])->name('verifications.show');
    Route::post('/verifications/{report}/verify', [VerificationController::class, 'verify'])->name('verifications.verify');
    Route::post('/verifications/{report}/reject', [VerificationController::class, 'reject'])->name('verifications.reject');

    // Assign
    Route::get('/assignments', [AssignmentController::class, 'index'])->name('assignments.index');
    Route::get('/assignments/{report}', [AssignmentController::class, 'show'])->name('assignments.show');
    Route::post('/assignments/{report}', [AssignmentController::class, 'assign'])->name('assignments.assign');
    Route::delete('/assignments/{report}', [AssignmentController::class, 'unassign'])->name('assignments.unassign');

    // Semua Laporan
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/{report}', [ReportController::class, 'show'])->name('reports.show');
    Route::post('/reports/{report}/close', [ReportController::class, 'close'])->name('reports.close');

    // Manajemen Tim
    Route::resource('teams', TeamController::class);
    Route::post('teams/{team}/members', [TeamController::class, 'addMember'])->name('teams.addMember');
    Route::delete('teams/{team}/members/{user}', [TeamController::class, 'removeMember'])->name('teams.removeMember');
    
    // Manajemen Petugas (Menggunakan parameter {user} agar tidak bentrok)
    Route::get('/petugas', [PetugasController::class, 'index'])->name('petugas.index');
    Route::get('/petugas/create', [PetugasController::class, 'create'])->name('petugas.create');
    Route::post('/petugas', [PetugasController::class, 'store'])->name('petugas.store');
    Route::get('/petugas/{user}/edit', [PetugasController::class, 'edit'])->name('petugas.edit');
    Route::put('/petugas/{user}', [PetugasController::class, 'update'])->name('petugas.update');
    Route::delete('/petugas/{user}', [PetugasController::class, 'destroy'])->name('petugas.destroy');
    Route::post('/petugas/{user}/toggle-status', [PetugasController::class, 'toggleStatus'])->name('petugas.toggleStatus');
});
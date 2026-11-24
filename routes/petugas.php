<?php

use App\Http\Controllers\Petugas\DashboardController;
use App\Http\Controllers\Petugas\TaskController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'role:petugas'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');
    
    // Rute Riwayat harus di atas {report}
    Route::get('/tasks/history', [TaskController::class, 'history'])->name('tasks.history');
    
    Route::get('/tasks/{report}', [TaskController::class, 'show'])->name('tasks.show');
    Route::post('/tasks/{report}/accept', [TaskController::class, 'accept'])->name('tasks.accept');
    Route::post('/tasks/{report}/complete', [TaskController::class, 'complete'])->name('tasks.complete');
});
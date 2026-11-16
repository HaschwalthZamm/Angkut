<?php

use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Public\PublicReportController;
use App\Http\Controllers\Public\TrackingController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    $regions = \App\Models\Region::where('is_active', true)->orderBy('name')->get();
    return view('landing', compact('regions'));
})->name('home');

Route::get('/lapor', [PublicReportController::class, 'create'])->name('public.report.create');
Route::post('/lapor', [PublicReportController::class, 'store'])
    ->middleware('throttle:10,60')
    ->name('public.report.store');

Route::get('/tracking', [TrackingController::class, 'create'])->name('public.tracking.create');
Route::post('/tracking', [TrackingController::class, 'track'])->name('public.tracking.track');

/*
|--------------------------------------------------------------------------
| Auth routes (Dashboard, Profile, Notifications)
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        $user = auth()->user();
        return match (true) {
            $user->isAdmin()      => redirect()->route('admin.dashboard'),
            $user->isPetugas()    => redirect()->route('petugas.dashboard'),
            $user->isMasyarakat() => redirect()->route('masyarakat.dashboard'),
            default               => redirect('/'),
        };
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Notifikasi
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/notifications/read-all', [NotificationController::class, 'markAllAsRead'])->name('notifications.readAll');
});

require __DIR__ . '/auth.php';
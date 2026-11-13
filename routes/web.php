<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Public\PublicReportController;
use App\Http\Controllers\Public\TrackingController;
use App\Models\Region;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public routes
|--------------------------------------------------------------------------
*/

// Route utama mengarah ke Landing Page & kirim data kecamatan
Route::get('/', function () {
    $regions = Region::where('is_active', true)->orderBy('name')->get();
    return view('public.Landing', compact('regions'));
})->name('home');

// Guest bisa lapor tanpa login
Route::post('/lapor', [PublicReportController::class, 'store'])
    ->middleware('throttle:10,60')
    ->name('public.report.store');

// Guest tracking
Route::post('/tracking', [TrackingController::class, 'track'])
    ->name('public.tracking.track');

/*
|--------------------------------------------------------------------------
| Redirect dashboard berdasarkan role
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', function () {
    $user = auth()->user();

    return match (true) {
        $user->isAdmin()      => redirect()->route('admin.dashboard'),
        $user->isPetugas()    => redirect()->route('petugas.dashboard'),
        $user->isMasyarakat() => redirect()->route('masyarakat.dashboard'),
        default               => redirect('/'),
    };
})->middleware(['auth'])->name('dashboard');

/*
|--------------------------------------------------------------------------
| Profile (dari Breeze)
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
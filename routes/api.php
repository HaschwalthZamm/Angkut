<?php

use App\Http\Controllers\Public\TrackingController;
use App\Http\Requests\Report\TrackReportRequest;
use App\Http\Resources\ReportResource;
use App\Http\Resources\TrackingResource;
use App\Http\Resources\UserResource;
use App\Services\TrackingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::post('track', function (TrackReportRequest $request, TrackingService $trackingService) {
        $report = $trackingService->find(
            $request->string('tracking_code')->toString(),
            $request->string('phone')->toString(),
        );

        abort_unless($report, 404, 'Laporan tidak ditemukan.');

        return TrackingResource::make($report);
    });

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('user', fn (Request $request) => UserResource::make($request->user()));
        Route::get('reports', function (Request $request) {
            return ReportResource::collection(
                $request->user()->reports()->with(['region', 'category'])->latest()->paginate(10)
            );
        });
    });
});

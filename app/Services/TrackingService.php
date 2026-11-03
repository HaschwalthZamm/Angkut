<?php

namespace App\Services;

use App\Models\Report;

class TrackingService
{
    public function find(string $trackingCode, string $phone): ?Report
    {
        $normalized = preg_replace('/\D+/', '', $phone);

        return Report::query()
            ->with(['region', 'category', 'images', 'statusHistories'])
            ->where('tracking_code', strtoupper($trackingCode))
            ->where(function ($query) use ($phone, $normalized) {
                $query->where('guest_phone', $phone)
                    ->orWhereRaw("REPLACE(REPLACE(REPLACE(guest_phone, ' ', ''), '-', ''), '+', '') = ?", [$normalized])
                    ->orWhereHas('reporter', function ($reporter) use ($phone, $normalized) {
                        $reporter->where('phone', $phone)
                            ->orWhereRaw("REPLACE(REPLACE(REPLACE(phone, ' ', ''), '-', ''), '+', '') = ?", [$normalized]);
                    });
            })
            ->first();
    }
}

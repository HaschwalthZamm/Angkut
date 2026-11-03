<?php

namespace App\Support;

use App\Models\Report;
use Carbon\Carbon;

class TrackingCodeGenerator
{
    /**
     * Format: ANGKUT-YYMM-XXXX
     * Contoh: ANGKUT-2511-0001, ANGKUT-2511-0002
     * Sequence reset tiap bulan.
     */
    public function generate(): string
    {
        $prefix = config('angkut.tracking.prefix', 'ANGKUT');
        $period = Carbon::now()->format('ym'); // 2511 (Nov 2025)

        // Coba beberapa kali kalau ada race condition
        for ($attempt = 0; $attempt < 5; $attempt++) {
            $sequence = $this->nextSequence($prefix, $period);
            $code = sprintf('%s-%s-%04d', $prefix, $period, $sequence);

            $exists = Report::withTrashed()
                ->where('tracking_code', $code)
                ->exists();

            if (!$exists) {
                return $code;
            }
        }

        // Fallback super jarang terjadi: random suffix
        return sprintf('%s-%s-%s', $prefix, $period, strtoupper(substr(uniqid(), -4)));
    }

    private function nextSequence(string $prefix, string $period): int
    {
        $pattern = $prefix . '-' . $period . '-%';

        $last = Report::withTrashed()
            ->where('tracking_code', 'like', $pattern)
            ->orderByDesc('id')
            ->value('tracking_code');

        if (!$last) {
            return 1;
        }

        return (int) substr($last, -4) + 1;
    }
}
<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Throwable;

class GeocodingService
{
    public function reverse(float $latitude, float $longitude): ?string
    {
        try {
            $response = Http::withHeaders([
                'User-Agent' => config('angkut.geocoding.user_agent', 'Angkut/1.0'),
            ])
                ->timeout(8)
                ->get(rtrim(config('angkut.geocoding.base_url'), '/').'/reverse', [
                    'lat' => $latitude,
                    'lon' => $longitude,
                    'format' => 'json',
                ]);

            if (! $response->successful()) {
                return null;
            }

            return $response->json('display_name');
        } catch (Throwable $e) {
            Log::warning('Geocoding gagal: '.$e->getMessage());

            return null;
        }
    }
}

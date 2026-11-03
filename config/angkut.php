<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Upload Foto
    |--------------------------------------------------------------------------
    */
    'max_foto' => (int) env('ANGKUT_MAX_FOTO', 5),

    /*
    |--------------------------------------------------------------------------
    | SLA (dalam jam) per priority
    |--------------------------------------------------------------------------
    */
    'sla' => [
        'urgent_hours' => (int) env('ANGKUT_SLA_URGENT_HOURS', 4),
        'high_hours'   => (int) env('ANGKUT_SLA_HIGH_HOURS', 12),
        'medium_hours' => (int) env('ANGKUT_SLA_MEDIUM_HOURS', 24),
        'low_hours'    => (int) env('ANGKUT_SLA_LOW_HOURS', 48),
    ],

    /*
    |--------------------------------------------------------------------------
    | Tracking Code
    |--------------------------------------------------------------------------
    */
    'tracking' => [
        'prefix'   => env('ANGKUT_TRACKING_PREFIX', 'ANGKUT'),
        'ttl_days' => (int) env('ANGKUT_TRACKING_TTL_DAYS', 30),
    ],

    /*
    |--------------------------------------------------------------------------
    | Geocoding (Nominatim, gratis)
    |--------------------------------------------------------------------------
    */
    'geocoding' => [
        'provider'   => 'nominatim',
        'base_url'   => 'https://nominatim.openstreetmap.org',
        'user_agent' => env('NOMINATIM_USER_AGENT', 'Angkut/1.0 (dev@angkut.id)'),
    ],
];
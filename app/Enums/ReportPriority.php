<?php

namespace App\Enums;

enum ReportPriority: string
{
    case Low    = 'low';
    case Medium = 'medium';
    case High   = 'high';
    case Urgent = 'urgent';

    public function label(): string
    {
        return match ($this) {
            self::Low    => 'Rendah',
            self::Medium => 'Sedang',
            self::High   => 'Tinggi',
            self::Urgent => 'Mendesak',
        };
    }

    public function weight(): int
    {
        return match ($this) {
            self::Low    => 1,
            self::Medium => 2,
            self::High   => 3,
            self::Urgent => 4,
        };
    }
}
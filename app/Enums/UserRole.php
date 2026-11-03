<?php

namespace App\Enums;

enum UserRole: string
{
    case Masyarakat = 'masyarakat';
    case Admin      = 'admin';
    case Petugas    = 'petugas';

    public function label(): string
    {
        return match ($this) {
            self::Masyarakat => 'Masyarakat',
            self::Admin      => 'Admin Pusat',
            self::Petugas    => 'Petugas Lapangan',
        };
    }
}
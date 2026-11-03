<?php

namespace App\Enums;

enum ReportStatus: string
{
    case Pending    = 'pending';
    case Verified   = 'verified';
    case Rejected   = 'rejected';
    case Assigned   = 'assigned';
    case OnProgress = 'on_progress';
    case Completed  = 'completed';
    case Closed     = 'closed';

    public function label(): string
    {
        return match ($this) {
            self::Pending    => 'Menunggu Verifikasi',
            self::Verified   => 'Terverifikasi',
            self::Rejected   => 'Ditolak',
            self::Assigned   => 'Ditugaskan',
            self::OnProgress => 'Sedang Ditangani',
            self::Completed  => 'Selesai',
            self::Closed     => 'Ditutup',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::Pending    => 'yellow',
            self::Verified   => 'blue',
            self::Rejected   => 'red',
            self::Assigned   => 'indigo',
            self::OnProgress => 'orange',
            self::Completed  => 'green',
            self::Closed     => 'gray',
        };
    }

    public function isActive(): bool
    {
        return in_array($this, [
            self::Pending,
            self::Verified,
            self::Assigned,
            self::OnProgress,
        ], true);
    }

    public function isFinal(): bool
    {
        return in_array($this, [
            self::Rejected,
            self::Completed,
            self::Closed,
        ], true);
    }

    /**
     * State machine transisi status yang diizinkan.
     *
     * Flow normal:
     *   pending → verified → assigned → on_progress → completed → closed
     *
     * Flow tolak:
     *   pending → rejected
     *   verified → rejected
     *
     * Flow reopen (admin salah tolak):
     *   rejected → verified
     *
     * Flow rollback (petugas tolak tugas, admin unassign):
     *   assigned → verified
     */
    public function canTransitionTo(self $next): bool
    {
        return match ($this) {
            self::Pending => in_array($next, [
                self::Verified,
                self::Rejected,
            ], true),

            self::Verified => in_array($next, [
                self::Assigned,
                self::Rejected,
            ], true),

            self::Assigned => in_array($next, [
                self::OnProgress,
                self::Verified, // rollback: petugas tolak tugas / admin unassign
            ], true),

            self::OnProgress => in_array($next, [
                self::Completed,
            ], true),

            self::Completed => in_array($next, [
                self::Closed,
            ], true),

            self::Rejected => in_array($next, [
                self::Verified, // reopen oleh admin
            ], true),

            self::Closed => false,
        };
    }
}
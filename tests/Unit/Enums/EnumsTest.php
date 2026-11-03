<?php

namespace Tests\Unit\Enums;

use App\Enums\ReportStatus;
use App\Enums\UserRole;
use PHPUnit\Framework\TestCase;

class EnumsTest extends TestCase
{
    public function test_user_roles(): void
    {
        $this->assertEquals('masyarakat', UserRole::Masyarakat->value);
        $this->assertEquals('admin', UserRole::Admin->value);
        $this->assertEquals('petugas', UserRole::Petugas->value);
    }

    public function test_report_status_transitions(): void
    {
        $this->assertTrue(ReportStatus::Pending->canTransitionTo(ReportStatus::Verified));
        $this->assertFalse(ReportStatus::Pending->canTransitionTo(ReportStatus::Completed));
    }
}

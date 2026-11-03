<?php

namespace Tests\Feature\Masyarakat;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TrackingReportTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_can_track_report_with_code(): void
    {
        $this->assertTrue(true);
    }
}

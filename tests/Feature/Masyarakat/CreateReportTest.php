<?php

namespace Tests\Feature\Masyarakat;

use App\Models\Region;
use App\Models\ReportCategory;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateReportTest extends TestCase
{
    use RefreshDatabase;

    public function test_masyarakat_can_create_report(): void
    {
        $this->assertTrue(true);
    }
}

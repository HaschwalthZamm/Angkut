<?php

namespace Tests\Unit\Services;

use App\Support\TrackingCodeGenerator;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TrackingCodeGeneratorTest extends TestCase
{
    use RefreshDatabase;

    public function test_generate_tracking_code_format(): void
    {
        $generator = new TrackingCodeGenerator();
        $code = $generator->generate();
        $this->assertMatchesRegularExpression('/^ANGKUT-\d{4}-[A-Z0-9]{4}$/', $code);
    }
}

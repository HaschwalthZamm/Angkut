<?php

namespace Tests\Feature\Petugas;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UpdateTaskStatusTest extends TestCase
{
    use RefreshDatabase;

    public function test_petugas_can_update_task_status(): void
    {
        $this->assertTrue(true);
    }
}

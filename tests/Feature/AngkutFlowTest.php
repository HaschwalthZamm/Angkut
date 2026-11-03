<?php

namespace Tests\Feature;

use App\Enums\ReportStatus;
use App\Models\Report;
use App\Models\Team;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AngkutFlowTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;
    protected User $petugas;
    protected User $warga;
    protected Team $tim;

    protected function setUp(): void
    {
        parent::setUp();

        // Seed data master & user via SQL seeder yang sudah ada
        $this->seed(\Database\Seeders\RolePermissionSeeder::class ?? \Database\Seeders\DatabaseSeeder::class);

        // Ambil data yang sudah di-seed
        $this->admin   = User::where('email', 'admin@angkut.id')->firstOrFail();
        $this->petugas = User::where('email', 'petugas1@angkut.id')->firstOrFail();
        $this->warga   = User::where('email', 'warga@angkut.id')->firstOrFail();
        $this->tim     = Team::where('code', 'TIM-ILIR-BARAT-I-01')->firstOrFail();
    }

    // ============================================================
    // PUBLIC FLOW — Guest report & tracking
    // ============================================================

    public function test_guest_can_create_report(): void
    {
        $payload = [
            'region_id'          => $this->tim->region_id,
            'report_category_id' => \App\Models\ReportCategory::first()->id,
            'title'              => 'Sampah menumpuk di pasar',
            'description'        => 'Sudah 3 hari tidak diangkut',
            'latitude'           => -2.99,
            'longitude'          => 104.75,
            'priority'           => 'high',
            'reporter_name'      => 'Warga Anonim',
            'reporter_phone'     => '081234567890',
        ];

        $response = $this->postJson('/lapor', $payload);

        $response->assertStatus(201)
            ->assertJsonPath('success', true)
            ->assertJsonStructure([
                'data' => ['tracking_code', 'status', 'title'],
            ]);

        $this->assertDatabaseHas('reports', [
            'title'          => 'Sampah menumpuk di pasar',
            'reporter_phone' => '081234567890',
            'user_id'        => null,
        ]);
    }

    public function test_guest_can_track_report(): void
    {
        $report = $this->createGuestReport();

        $response = $this->postJson('/tracking', [
            'tracking_code' => $report->tracking_code,
            'phone'         => '081234567890',
        ]);

        $response->assertStatus(200)
            ->assertJsonPath('success', true)
            ->assertJsonPath('data.tracking_code', $report->tracking_code);
    }

    public function test_guest_tracking_fails_with_wrong_phone(): void
    {
        $report = $this->createGuestReport();

        $response = $this->postJson('/tracking', [
            'tracking_code' => $report->tracking_code,
            'phone'         => '089999999999',
        ]);

        $response->assertStatus(404)
            ->assertJsonPath('success', false);
    }

    // ============================================================
    // ADMIN FLOW — Verify & Assign
    // ============================================================

    public function test_admin_can_verify_pending_report(): void
    {
        $report = $this->createGuestReport();

        $response = $this->actingAs($this->admin)
            ->postJson("/admin/verifications/{$report->id}/verify", [
                'note' => 'Laporan valid.',
            ]);

        $response->assertStatus(200)
            ->assertJsonPath('data.status', ReportStatus::Verified->value);

        $this->assertDatabaseHas('reports', [
            'id'     => $report->id,
            'status' => ReportStatus::Verified->value,
        ]);
    }

    public function test_admin_can_reject_report_with_reason(): void
    {
        $report = $this->createGuestReport();

        $response = $this->actingAs($this->admin)
            ->postJson("/admin/verifications/{$report->id}/reject", [
                'reason' => 'Foto tidak jelas.',
            ]);

        $response->assertStatus(200)
            ->assertJsonPath('data.status', ReportStatus::Rejected->value)
            ->assertJsonPath('data.rejected_reason', 'Foto tidak jelas.');
    }

    public function test_admin_can_assign_verified_report_to_team(): void
    {
        $report = $this->createVerifiedReport();

        $response = $this->actingAs($this->admin)
            ->postJson("/admin/assignments/{$report->id}", [
                'team_id' => $this->tim->id,
            ]);

        $response->assertStatus(200)
            ->assertJsonPath('success', true)
            ->assertJsonPath('data.team.name', $this->tim->name);

        $this->assertDatabaseHas('reports', [
            'id'     => $report->id,
            'status' => ReportStatus::Assigned->value,
        ]);

        $this->assertDatabaseHas('assignments', [
            'report_id' => $report->id,
            'team_id'   => $this->tim->id,
            'is_active' => true,
        ]);
    }

    public function test_admin_cannot_assign_report_to_team_in_different_region(): void
    {
        $regionLain = \App\Models\Region::where('code', 'SUKARAMI')->firstOrFail();
        $timLain = Team::create([
            'region_id' => $regionLain->id,
            'name'      => 'Tim Sukarami',
            'code'      => 'TIM-SUKARAMI-TEST',
            'status'    => 'active',
        ]);

        $report = $this->createVerifiedReport();

        $response = $this->actingAs($this->admin)
            ->postJson("/admin/assignments/{$report->id}", [
                'team_id' => $timLain->id,
            ]);

        $response->assertStatus(422);
    }

    // ============================================================
    // PETUGAS FLOW — Accept, Start, Complete
    // ============================================================

    public function test_petugas_can_accept_start_and_complete_task(): void
    {
        $report = $this->createAssignedReport();

        // Accept
        $this->actingAs($this->petugas)
            ->postJson("/petugas/tasks/{$report->id}/accept")
            ->assertStatus(200)
            ->assertJsonPath('success', true);

        // Start
        $this->actingAs($this->petugas)
            ->postJson("/petugas/tasks/{$report->id}/start")
            ->assertStatus(200)
            ->assertJsonPath('data.status', ReportStatus::OnProgress->value);

        // Complete
        $this->actingAs($this->petugas)
            ->postJson("/petugas/tasks/{$report->id}/complete")
            ->assertStatus(200)
            ->assertJsonPath('data.status', ReportStatus::Completed->value);

        $this->assertDatabaseHas('reports', [
            'id'     => $report->id,
            'status' => ReportStatus::Completed->value,
        ]);
    }

    public function test_petugas_cannot_access_other_team_task(): void
    {
        $regionLain = \App\Models\Region::where('code', 'SUKARAMI')->firstOrFail();
        $timLain = Team::create([
            'region_id' => $regionLain->id,
            'name'      => 'Tim Sukarami',
            'code'      => 'TIM-SUKARAMI-TEST',
            'status'    => 'active',
        ]);

        $report = $this->createReportInRegion($regionLain->id);
        app(\App\Services\ReportStatusService::class)->verify($report, $this->admin);
        app(\App\Services\AssignmentService::class)->assign(
            $report->fresh(), $timLain, $this->admin
        );

        $response = $this->actingAs($this->petugas)
            ->getJson("/petugas/tasks/{$report->id}");

        $response->assertStatus(422); // petugas tidak tergabung di tim
    }

    // ============================================================
    // CLOSE
    // ============================================================

    public function test_admin_can_close_completed_report(): void
    {
        $report = $this->createAssignedReport();

        app(\App\Services\ReportStatusService::class)->start($report->fresh(), $this->petugas);
        app(\App\Services\ReportStatusService::class)->complete($report->fresh(), $this->petugas);

        $response = $this->actingAs($this->admin)
            ->postJson("/admin/reports/{$report->id}/close");

        $response->assertStatus(200)
            ->assertJsonPath('data.status', ReportStatus::Closed->value);
    }

    // ============================================================
    // NOTIFICATION
    // ============================================================

    public function test_admin_receives_notification_on_new_report(): void
    {
        $this->createGuestReport();

        $this->assertGreaterThan(0, $this->admin->notifications()->count());
    }

    public function test_warga_receives_notification_on_verify(): void
    {
        $report = $this->createUserReport();

        $before = $this->warga->notifications()->count();

        app(\App\Services\ReportStatusService::class)->verify($report, $this->admin);

        $this->assertGreaterThan($before, $this->warga->notifications()->count());
    }

    // ============================================================
    // HELPERS
    // ============================================================

    private function createGuestReport(): Report
    {
        return app(\App\Services\ReportService::class)->createReport([
            'region_id'          => $this->tim->region_id,
            'report_category_id' => \App\Models\ReportCategory::first()->id,
            'title'              => 'Test guest report',
            'description'        => 'Test',
            'latitude'           => -2.99,
            'longitude'          => 104.75,
            'priority'           => 'medium',
            'reporter_name'      => 'Guest',
            'reporter_phone'     => '081234567890',
        ]);
    }

    private function createUserReport(): Report
    {
        return app(\App\Services\ReportService::class)->createReport([
            'region_id'          => $this->tim->region_id,
            'report_category_id' => \App\Models\ReportCategory::first()->id,
            'title'              => 'Test user report',
            'description'        => 'Test',
            'latitude'           => -2.99,
            'longitude'          => 104.75,
            'priority'           => 'medium',
        ], $this->warga);
    }

    private function createVerifiedReport(): Report
    {
        $report = $this->createGuestReport();
        return app(\App\Services\ReportStatusService::class)->verify($report, $this->admin);
    }

    private function createAssignedReport(): Report
    {
        $report = $this->createVerifiedReport();
        app(\App\Services\AssignmentService::class)->assign($report->fresh(), $this->tim, $this->admin);
        return $report->fresh();
    }

    private function createReportInRegion(int $regionId): Report
    {
        return app(\App\Services\ReportService::class)->createReport([
            'region_id'          => $regionId,
            'report_category_id' => \App\Models\ReportCategory::first()->id,
            'title'              => 'Test report region lain',
            'description'        => 'Test',
            'latitude'           => -2.99,
            'longitude'          => 104.75,
            'reporter_name'      => 'Guest',
            'reporter_phone'     => '081234567891',
        ]);
    }
}
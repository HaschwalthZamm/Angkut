<?php

namespace App\Services;

use App\Enums\ReportPriority;
use App\Enums\ReportStatus;
use App\Events\ReportCreated;
use App\Models\Report;
use App\Models\ReportCategory;
use App\Models\Region;
use App\Models\User;
use App\Support\TrackingCodeGenerator;
use Carbon\Carbon;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class ReportService
{
    public function __construct(
        private TrackingCodeGenerator $codeGenerator,
    ) {}

    /**
     * Buat laporan baru (guest atau user login).
     */
    public function createReport(array $data, ?User $user = null): Report
    {
        // 1. Validasi region & category aktif
        $region = Region::where('id', $data['region_id'] ?? 0)
            ->where('is_active', true)
            ->first();

        if (!$region) {
            throw ValidationException::withMessages([
                'region_id' => 'Wilayah tidak ditemukan atau tidak aktif.',
            ]);
        }

        $category = ReportCategory::where('id', $data['report_category_id'] ?? 0)
            ->where('is_active', true)
            ->first();

        if (!$category) {
            throw ValidationException::withMessages([
                'report_category_id' => 'Kategori sampah tidak ditemukan atau tidak aktif.',
            ]);
        }

        // 2. Tentukan reporter (dari user login atau dari input guest)
        $reporterName  = $user?->name  ?? ($data['reporter_name']  ?? null);
        $reporterPhone = $user?->phone ?? ($data['reporter_phone'] ?? null);

        if (empty($reporterName)) {
            throw ValidationException::withMessages([
                'reporter_name' => 'Nama pelapor wajib diisi.',
            ]);
        }

        if (empty($reporterPhone)) {
            throw ValidationException::withMessages([
                'reporter_phone' => 'Nomor HP pelapor wajib diisi.',
            ]);
        }

        // 3. Normalisasi phone
        $reporterPhone = $this->normalizePhone($reporterPhone);

        // 4. Priority & SLA
        $priority = $this->resolvePriority($data['priority'] ?? 'medium');
        $slaHours = $this->slaHoursFor($priority);

        // 5. Buat report dalam transaction
        $report = DB::transaction(function () use (
            $data, $user, $reporterName, $reporterPhone, $priority, $slaHours
        ) {
            $report = Report::create([
                'tracking_code'      => $this->codeGenerator->generate(),
                'user_id'            => $user?->id,
                'reporter_name'      => $reporterName,
                'reporter_phone'     => $reporterPhone,
                'region_id'          => $data['region_id'],
                'report_category_id' => $data['report_category_id'],
                'title'              => $data['title'],
                'description'        => $data['description'],
                'address'            => $data['address'] ?? null,
                'latitude'           => $data['latitude'],
                'longitude'          => $data['longitude'],
                'priority'           => $priority,
                'status'             => ReportStatus::Pending,
                'sla_deadline_at'    => Carbon::now()->addHours($slaHours),
            ]);

            // Simpan foto
            if (!empty($data['images'])) {
                $this->attachImages($report, $data['images'], $user);
            }

            // Catat status history awal
            $report->statusHistories()->create([
                'status'     => ReportStatus::Pending,
                'changed_by' => $user?->id,
                'note'       => 'Laporan dibuat.',
                'created_at' => Carbon::now(),
            ]);

            Log::info('Report created', [
                'id'            => $report->id,
                'tracking_code' => $report->tracking_code,
                'is_guest'      => $user === null,
            ]);

            return $report;
        });

        // 6. Fire event SETELAH transaction commit
        ReportCreated::dispatch($report);

        return $report;
    }

    /**
     * Cek laporan via tracking code + nomor HP (untuk guest tracking).
     */
    public function trackReport(string $trackingCode, string $phone): ?Report
    {
        return Report::where('tracking_code', $trackingCode)
            ->where('reporter_phone', $this->normalizePhone($phone))
            ->with([
                'region',
                'category',
                'images',
                'statusHistories',
                'activeAssignment.team',
                'feedback',
            ])
            ->first();
    }

    // -----------------------------------------------------------------
    // Private helpers
    // -----------------------------------------------------------------

    private function resolvePriority(string|ReportPriority $value): ReportPriority
    {
        if ($value instanceof ReportPriority) {
            return $value;
        }

        return ReportPriority::tryFrom($value) ?? ReportPriority::Medium;
    }

    private function slaHoursFor(ReportPriority $priority): int
    {
        return match ($priority) {
            ReportPriority::Urgent => config('angkut.sla.urgent_hours', 4),
            ReportPriority::High   => config('angkut.sla.high_hours', 12),
            ReportPriority::Medium => config('angkut.sla.medium_hours', 24),
            ReportPriority::Low    => config('angkut.sla.low_hours', 48),
        };
    }

    private function normalizePhone(string $phone): string
    {
        $phone = preg_replace('/\D/', '', $phone);

        if (str_starts_with($phone, '62')) {
            $phone = '0' . substr($phone, 2);
        }

        if (!str_starts_with($phone, '0')) {
            $phone = '0' . $phone;
        }

        return $phone;
    }

    /**
     * @param array<UploadedFile|string> $images
     */
    private function attachImages(Report $report, array $images, ?User $user): void
    {
        $max = (int) config('angkut.max_foto', 5);
        $images = array_slice($images, 0, $max);

        $sortOrder = 0;

        foreach ($images as $image) {
            if ($image instanceof UploadedFile) {
                $path = $image->store('reports/' . $report->id, 'public');
            } else {
                $path = (string) $image;
            }

            $report->images()->create([
                'type'        => 'report',
                'path'        => $path,
                'uploaded_by' => $user?->id,
                'sort_order'  => $sortOrder++,
            ]);
        }
    }
}
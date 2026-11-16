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

    public function createReport(array $data, ?User $user = null): Report
    {
        $region = Region::where('id', $data['region_id'] ?? 0)->where('is_active', true)->first();
        if (!$region) {
            throw ValidationException::withMessages(['region_id' => 'Wilayah tidak ditemukan atau tidak aktif.']);
        }

        $category = ReportCategory::where('id', $data['report_category_id'] ?? 0)->where('is_active', true)->first();
        if (!$category) {
            throw ValidationException::withMessages(['report_category_id' => 'Kategori sampah tidak ditemukan atau tidak aktif.']);
        }

        $reporterName  = $user?->name  ?? ($data['reporter_name']  ?? null);
        $reporterPhone = $user?->phone ?? ($data['reporter_phone'] ?? null);

        if (empty($reporterName)) {
            throw ValidationException::withMessages(['reporter_name' => 'Nama pelapor wajib diisi.']);
        }
        if (empty($reporterPhone)) {
            throw ValidationException::withMessages(['reporter_phone' => 'Nomor HP pelapor wajib diisi.']);
        }

        $reporterPhone = $this->normalizePhone($reporterPhone);
        $priority = $this->resolvePriority($data['priority'] ?? 'medium');
        $slaHours = $this->slaHoursFor($priority);

        $report = DB::transaction(function () use ($data, $user, $reporterName, $reporterPhone, $priority, $slaHours) {
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

            if (!empty($data['images'])) {
                $this->attachImages($report, $data['images'], $user);
            }

            $report->statusHistories()->create([
                'status'     => ReportStatus::Pending,
                'changed_by' => $user?->id,
                'note'       => 'Laporan dibuat.',
                'created_at' => Carbon::now(),
            ]);

            return $report;
        });

        ReportCreated::dispatch($report);
        return $report;
    }

    /**
     * Cek laporan berdasarkan nomor HP (bisa lebih dari 1 laporan)
     */
    public function trackReportsByPhone(string $phone)
    {
        return Report::where('reporter_phone', $this->normalizePhone($phone))
            ->with([
                'region',
                'category',
                'images',
                'statusHistories',
                'activeAssignment.team',
                'feedback',
            ])
            ->orderByDesc('created_at')
            ->get();
    }

    private function resolvePriority(string|ReportPriority $value): ReportPriority
    {
        if ($value instanceof ReportPriority) return $value;
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
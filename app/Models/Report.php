<?php

namespace App\Models;

use App\Enums\ReportPriority;
use App\Enums\ReportStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Report extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'tracking_code',
        'user_id',
        'reporter_name',
        'reporter_phone',
        'region_id',
        'report_category_id',
        'title',
        'description',
        'address',
        'latitude',
        'longitude',
        'priority',
        'status',
        'rejected_reason',
        'verified_by',
        'verified_at',
        'completed_at',
        'sla_deadline_at',
    ];

    protected function casts(): array
    {
        return [
            'latitude'        => 'decimal:8',
            'longitude'       => 'decimal:8',
            'priority'        => ReportPriority::class,
            'status'          => ReportStatus::class,
            'verified_at'     => 'datetime',
            'completed_at'    => 'datetime',
            'sla_deadline_at' => 'datetime',
        ];
    }

    // ---------------------------------------------------------
    // Relations
    // ---------------------------------------------------------

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function verifier(): BelongsTo
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    public function region(): BelongsTo
    {
        return $this->belongsTo(Region::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(ReportCategory::class, 'report_category_id');
    }

    public function images(): HasMany
    {
        return $this->hasMany(ReportImage::class);
    }

    public function reportImages(): HasMany
    {
        return $this->hasMany(ReportImage::class)->where('type', 'report');
    }

    public function evidenceImages(): HasMany
    {
        return $this->hasMany(ReportImage::class)->where('type', 'evidence');
    }

    public function statusHistories(): HasMany
    {
        return $this->hasMany(ReportStatusHistory::class)->latest('created_at');
    }

    public function comments(): HasMany
    {
        return $this->hasMany(ReportComment::class);
    }

    public function publicComments(): HasMany
    {
        return $this->hasMany(ReportComment::class)->where('is_internal', false);
    }

    public function feedback(): HasOne
    {
        return $this->hasOne(ReportFeedback::class);
    }

    public function assignments(): HasMany
    {
        return $this->hasMany(Assignment::class);
    }

    /** Assignment yang sedang aktif (1 laporan = 1 assignment aktif) */
    public function activeAssignment(): HasOne
    {
        return $this->hasOne(Assignment::class)->where('is_active', true);
    }

    // ---------------------------------------------------------
    // Helpers
    // ---------------------------------------------------------

    public function isGuestReport(): bool
    {
        return $this->user_id === null;
    }

    public function isPending(): bool
    {
        return $this->status === ReportStatus::Pending;
    }

    public function isCompleted(): bool
    {
        return $this->status === ReportStatus::Completed;
    }

    /** Tim yang sedang menangani laporan ini (helper) */
    public function handlingTeam(): ?Team
    {
        return $this->activeAssignment?->team;
    }
}
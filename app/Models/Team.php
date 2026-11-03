<?php

namespace App\Models;

use App\Enums\TeamStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\SoftDeletes;

class Team extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'region_id',
        'name',
        'code',
        'leader_id',
        'phone',
        'status',
        'description',
    ];

    protected function casts(): array
    {
        return [
            'status' => TeamStatus::class,
        ];
    }

    public function region(): BelongsTo
    {
        return $this->belongsTo(Region::class);
    }

    public function leader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'leader_id');
    }

    public function members(): HasMany
    {
        return $this->hasMany(TeamMember::class);
    }

    public function activeMembers(): HasMany
    {
        return $this->hasMany(TeamMember::class)->whereNull('left_at');
    }

    public function assignments(): HasMany
    {
        return $this->hasMany(Assignment::class);
    }

    public function activeAssignments(): HasMany
    {
        return $this->hasMany(Assignment::class)->where('is_active', true);
    }

    /** Semua report yang pernah di-assign ke tim ini */
    public function reports(): HasManyThrough
    {
        return $this->hasManyThrough(
            Report::class,
            Assignment::class,
            'team_id',    // FK di assignments
            'id',         // FK di reports (target PK)
            'id',         // local key di teams
            'report_id'   // FK di assignments ke reports
        );
    }

    public function isActive(): bool
    {
        return $this->status === TeamStatus::Active;
    }
}
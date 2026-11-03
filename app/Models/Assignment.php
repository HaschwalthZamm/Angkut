<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Assignment extends Model
{
    use HasFactory;

    protected $fillable = [
        'report_id',
        'team_id',
        'assigned_by',
        'assigned_at',
        'accepted_at',
        'started_at',
        'completed_at',
        'is_active',
        'note',
    ];

    protected function casts(): array
    {
        return [
            'assigned_at'  => 'datetime',
            'accepted_at'  => 'datetime',
            'started_at'   => 'datetime',
            'completed_at' => 'datetime',
            'is_active'    => 'boolean',
        ];
    }

    // active_report_id adalah generated column → JANGAN dimasukkan fillable

    public function report(): BelongsTo
    {
        return $this->belongsTo(Report::class);
    }

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    public function assigner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_by');
    }
}
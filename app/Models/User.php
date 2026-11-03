<?php

namespace App\Models;

use App\Enums\UserRole;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'avatar_path',
        'is_active',
        'last_login_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'last_login_at'     => 'datetime',
            'password'          => 'hashed',
            'is_active'         => 'boolean',
        ];
    }

    // ---------------------------------------------------------
    // Role Helpers
    // ---------------------------------------------------------

    public function isAdmin(): bool
    {
        return $this->hasRole(UserRole::Admin->value);
    }

    public function isPetugas(): bool
    {
        return $this->hasRole(UserRole::Petugas->value);
    }

    public function isMasyarakat(): bool
    {
        return $this->hasRole(UserRole::Masyarakat->value);
    }

    /**
     * Nama route dashboard sesuai role.
     */
    public function dashboardRouteName(): string
    {
        return match (true) {
            $this->isAdmin()      => 'admin.dashboard',
            $this->isPetugas()    => 'petugas.dashboard',
            $this->isMasyarakat() => 'masyarakat.dashboard',
            default               => 'home',
        };
    }

    /**
     * URL redirect setelah login / register.
     */
    public function redirectTo(): string
    {
        $routeName = $this->dashboardRouteName();

        return $routeName === 'home'
            ? url('/')
            : route($routeName);
    }

    // ---------------------------------------------------------
    // Relations
    // ---------------------------------------------------------

    public function petugasProfile(): HasOne
    {
        return $this->hasOne(PetugasProfile::class);
    }

    public function reports(): HasMany
    {
        return $this->hasMany(Report::class);
    }

    public function verifiedReports(): HasMany
    {
        return $this->hasMany(Report::class, 'verified_by');
    }

    public function activeTeamMember(): HasOne
    {
        return $this->hasOne(TeamMember::class)->whereNull('left_at');
    }

    public function teamMemberships(): HasMany
    {
        return $this->hasMany(TeamMember::class);
    }

    public function ledTeam(): HasOne
    {
        return $this->hasOne(Team::class, 'leader_id');
    }

    public function activeTeam(): ?Team
    {
        return $this->activeTeamMember?->team;
    }

    public function comments(): HasMany
    {
        return $this->hasMany(ReportComment::class);
    }
}
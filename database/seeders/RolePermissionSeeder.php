<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

         = [
            'reports.view',
            'reports.create',
            'reports.verify',
            'reports.assign',
            'reports.update_status',
            'reports.export',
            'teams.manage',
            'users.manage',
        ];

        foreach ( as ) {
            Permission::findOrCreate(, 'web');
        }

         = Role::findOrCreate(UserRole::Masyarakat->value, 'web');
        ->syncPermissions(['reports.view', 'reports.create']);

         = Role::findOrCreate(UserRole::Petugas->value, 'web');
        ->syncPermissions(['reports.view', 'reports.update_status']);

         = Role::findOrCreate(UserRole::Admin->value, 'web');
        ->syncPermissions(Permission::all());
    }
}

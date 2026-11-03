<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
         = User::firstOrCreate(
            ['email' => 'admin@angkut.test'],
            [
                'name' => 'Administrator Angkut',
                'phone' => '081234567890',
                'password' => Hash::make('password'),
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );

        ->syncRoles([UserRole::Admin->value]);
    }
}

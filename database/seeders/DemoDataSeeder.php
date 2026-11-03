<?php

namespace Database\Seeders;

use App\Enums\ReportPriority;
use App\Enums\ReportStatus;
use App\Enums\TeamStatus;
use App\Enums\UserRole;
use App\Models\Region;
use App\Models\Report;
use App\Models\ReportCategory;
use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DemoDataSeeder extends Seeder
{
    public function run(): void
    {
         = User::firstOrCreate(
            ['email' => 'warga@angkut.test'],
            [
                'name' => 'Budi Santoso',
                'phone' => '081298765432',
                'password' => Hash::make('password'),
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );
        ->syncRoles([UserRole::Masyarakat->value]);

         = User::firstOrCreate(
            ['email' => 'petugas@angkut.test'],
            [
                'name' => 'Agus Setiawan',
                'phone' => '081345678912',
                'password' => Hash::make('password'),
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );
        ->syncRoles([UserRole::Petugas->value]);

         = Region::first();
        if () {
             = Team::firstOrCreate(
                ['region_id' => ->id, 'name' => 'Tim Respons Cepat ' . ->name],
                ['status' => TeamStatus::Active, 'description' => 'Tim percontohan demo']
            );

            if (!->users()->where('user_id', ->id)->exists()) {
                ->users()->attach(->id, ['is_leader' => true]);
            }

             = ReportCategory::first();
            if () {
                Report::firstOrCreate(
                    ['tracking_code' => 'ANGKUT-' . now()->format('ym') . '-DEMO'],
                    [
                        'user_id' => ->id,
                        'region_id' => ->id,
                        'report_category_id' => ->id,
                        'title' => 'Tumpukan Sampah di Pinggir Jalan Utama',
                        'description' => 'Sampah rumah tangga menumpuk dan berbau menyengat sejak 2 hari lalu.',
                        'address' => 'Jl. Jenderal Sudirman No. 12, ' . ->name,
                        'latitude' => -2.9760735,
                        'longitude' => 104.7578028,
                        'status' => ReportStatus::Pending,
                        'priority' => ReportPriority::Medium,
                    ]
                );
            }
        }
    }
}

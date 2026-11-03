<?php

namespace Database\Seeders;

use App\Enums\TeamStatus;
use App\Models\Region;
use App\Models\Team;
use Illuminate\Database\Seeder;

class TeamSeeder extends Seeder
{
    public function run(): void
    {
         = Region::all();

        foreach ( as ) {
            Team::firstOrCreate(
                ['name' => 'Tim Kebersihan ' . ->name, 'region_id' => ->id],
                [
                    'status' => TeamStatus::Active,
                    'description' => 'Tim operasional pengangkutan sampah wilayah ' . ->name,
                ]
            );
        }
    }
}

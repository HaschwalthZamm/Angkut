<?php

namespace Database\Seeders;

use App\Models\Region;
use Illuminate\Database\Seeder;

class RegionSeeder extends Seeder
{
    public function run(): void
    {
        $kecamatan = [
            'Ilir Barat I', 'Ilir Barat II', 'Ilir Timur I', 'Ilir Timur II',
            'Ilir Timur III', 'Sukarami', 'Seberang Ulu I', 'Seberang Ulu II',
            'Kemuning', 'Kalidoni', 'Bukit Kecil', 'Gandus',
            'Kertapati', 'Jakabaring', 'Plaju', 'Sako',
            'Sematang Borang', 'Alang-Alang Lebar',
        ];

        foreach ($kecamatan as $nama) {
            Region::firstOrCreate(['name' => $nama], [
                'code' => strtoupper(str_replace(' ', '-', $nama)),
            ]);
        }
    }
}
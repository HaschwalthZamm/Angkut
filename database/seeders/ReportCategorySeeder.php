<?php

namespace Database\Seeders;

use App\Models\ReportCategory;
use Illuminate\Database\Seeder;

class ReportCategorySeeder extends Seeder
{
    public function run(): void
    {
         = [
            ['name' => 'Sampah Liar', 'description' => 'Tumpukan sampah ilegal di ruang publik atau lahan kosong'],
            ['name' => 'TPS Penuh/Meluap', 'description' => 'Tempat pembuangan sampah sementara yang melebihi kapasitas'],
            ['name' => 'Jadwal Pengangkutan Terlewat', 'description' => 'Petugas angkut tidak mengambil sampah sesuai jadwal'],
            ['name' => 'Sampah Saluran Air/Drainase', 'description' => 'Sampah yang menyumbat selokan, parit, atau sungai'],
            ['name' => 'Sampah Berbahaya/Medis', 'description' => 'Limbah beracun, pecahan kaca besar, atau limbah medis'],
        ];

        foreach ( as ) {
            ReportCategory::firstOrCreate(
                ['name' => ['name']],
                ['description' => ['description'], 'is_active' => true]
            );
        }
    }
}

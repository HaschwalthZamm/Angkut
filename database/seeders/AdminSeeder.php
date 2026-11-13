<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@pusat.com'], // Kunci unik
            [
                'name' => 'Admin Pusat',
                'password' => Hash::make('password123'),
                'role' => 'admin', // Pastikan tabel users Anda punya kolom 'role'
            ]
        );
    }
}
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name' => 'Admin User',
                'email' => 'admin@example.com',
                'password' => Hash::make('password123'), // Simpan password dalam bentuk hash
                'role' => 'admin', // Pastikan nilai sesuai
                'prodi' => 'Teknik Informatika',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Dosen User',
                'email' => 'dosen@example.com',
                'password' => Hash::make('password123'),
                'role' => 'dosen', // Pastikan nilai sesuai
                'prodi' => 'Sistem Informasi',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Dekan User',
                'email' => 'dekan@example.com',
                'password' => Hash::make('password123'),
                'role' => 'dekan', // Pastikan nilai sesuai
                'prodi' => 'Sistem Informasi',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Mahasiswa User',
                'email' => 'mahasiswa@example.com',
                'password' => Hash::make('password123'),
                'role' => 'mahasiswa', // Pastikan nilai sesuai
                'prodi' => 'Teknik Informatika',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}

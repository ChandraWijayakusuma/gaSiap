<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(MahasiswaSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(RuangSeeder::class);
        $this->call(MatakuliahSeeder::class);
    }
    
}
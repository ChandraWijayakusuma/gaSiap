<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MahasiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('mahasiswas')->insert([
            [
                'created_at' => now(),
                'updated_at' => now(),
                'nama' => 'Andi',
                'semester' => '1',
                'status' => 'aktif',
            ],
            [
                'created_at' => now(),
                'updated_at' => now(),
                'nama' => 'Budi',
                'semester' => '1', 
                'status' => 'cuti',
            ],
        ]);
        
    }
}
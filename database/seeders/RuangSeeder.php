<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RuangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['nama_ruang' => 'A101', 'kuota_ruang' => 30, 'prodi' => null],
            ['nama_ruang' => 'A102', 'kuota_ruang' => 35, 'prodi' => null],
            ['nama_ruang' => 'A103', 'kuota_ruang' => 30, 'prodi' => null],
            ['nama_ruang' => 'A201', 'kuota_ruang' => 35, 'prodi' => null],
            ['nama_ruang' => 'A202', 'kuota_ruang' => 30, 'prodi' => null],
            ['nama_ruang' => 'A203', 'kuota_ruang' => 28, 'prodi' => null],
            ['nama_ruang' => 'B101', 'kuota_ruang' => 25, 'prodi' => null],
            ['nama_ruang' => 'B102', 'kuota_ruang' => 30, 'prodi' => null],
            ['nama_ruang' => 'B103', 'kuota_ruang' => 35, 'prodi' => null],
            ['nama_ruang' => 'B201', 'kuota_ruang' => 28, 'prodi' => null],
            ['nama_ruang' => 'B202', 'kuota_ruang' => 25, 'prodi' => null],
            ['nama_ruang' => 'B203', 'kuota_ruang' => 30, 'prodi' => null],
            ['nama_ruang' => 'C101', 'kuota_ruang' => 40, 'prodi' => null],
            ['nama_ruang' => 'C102', 'kuota_ruang' => 45, 'prodi' => null],
            ['nama_ruang' => 'C103', 'kuota_ruang' => 30, 'prodi' => null],
            ['nama_ruang' => 'E101', 'kuota_ruang' => 45, 'prodi' => null],
            ['nama_ruang' => 'E102', 'kuota_ruang' => 30, 'prodi' => null],
            ['nama_ruang' => 'E103', 'kuota_ruang' => 27, 'prodi' => null],
        ];

        DB::table('ruang')->insert($data);
    }
}

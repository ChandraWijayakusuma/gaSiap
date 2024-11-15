<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KelasSeeder extends Seeder
{
    public function run()
    {
        DB::table('kelas')->insert([
            [
                'nama_kelas' => 'A101',
                'kuota' => 30,
                'status' => 'kosong',
                'departemen_id' => null, // belum ditempati
            ],
            [
                'nama_kelas' => 'A102',
                'kuota' => 25,
                'status' => 'terisi',
                'departemen_id' => 1, // contoh ID departemen yang menempati kelas ini
            ],
            [
                'nama_kelas' => 'B201',
                'kuota' => 40,
                'status' => 'kosong',
                'departemen_id' => null, // belum ditempati
            ],
            // Tambahkan data kelas lainnya sesuai kebutuhan
        ]);
    }
}

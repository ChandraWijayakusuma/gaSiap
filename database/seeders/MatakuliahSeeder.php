<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MatakuliahSeeder extends Seeder
{
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('matakuliah')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');


        DB::table('matakuliah')->insert([
            ['kode_matakuliah' => 'MK101', 'nama_matakuliah' => 'Matematika', 'prodi' => 'Teknik Informatika', 'sks' => 3, 'deskripsi' => 'Matematika dasar untuk informatika','semester' => 1],
            ['kode_matakuliah' => 'MK102', 'nama_matakuliah' => 'Algoritma', 'prodi' => 'Teknik Informatika', 'sks' => 4, 'deskripsi' => 'Pengenalan Algoritma dan Pemrograman','semester' => 1],
            ['kode_matakuliah' => 'MK103', 'nama_matakuliah' => 'Basis Data', 'prodi' => 'Teknik Informatika', 'sks' => 3, 'deskripsi' => 'Pengenalan Database','semester' => 1],
            ['kode_matakuliah' => 'MK104', 'nama_matakuliah' => 'Cyber Security', 'prodi' => 'Teknik Informatika', 'sks' => 4, 'deskripsi' => 'Pengetahuan keamanan dunia cyber','semester' => 3],
            ['kode_matakuliah' => 'MK105', 'nama_matakuliah' => 'English', 'prodi' => 'Teknik Informatika', 'sks' => 2, 'deskripsi' => 'Pembelajaran bahasa inggris dasar','semester' => 1],
            ['kode_matakuliah' => 'MK106', 'nama_matakuliah' => 'Sistem Informasi', 'prodi' => 'Teknik Informatika', 'sks' => 2, 'deskripsi' => 'Pengenalan pergerakan informasi','semester' => 3],
            // Tambahkan data mata kuliah lainnya
        ]);
    }
}

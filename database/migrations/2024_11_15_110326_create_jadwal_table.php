<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJadwalTable extends Migration
{
    public function up()
    {
        Schema::create('jadwal', function (Blueprint $table) {
            $table->id();
            $table->enum('day', ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat']);
            $table->time('hour');
            $table->unsignedBigInteger('matakuliah_id');
            $table->string('room', 50);
            $table->enum('status', ['Setujui', 'Belum Setujui'])->default('Belum Setujui'); // Hanya 2 opsi status
            $table->timestamps();

            // Menghapus baris duplikat foreign key dan column lainnya
            $table->foreign('matakuliah_id')  // Relasi ke matakuliah
                  ->references('id')
                  ->on('matakuliah')
                  ->onDelete('cascade');
            
            // Kolom hari, jam_mulai dan jam_selesai
            $table->string('hari');
            $table->time('jam_mulai');
            $table->time('jam_selesai');
        });
    }

    public function down()
    {
        Schema::dropIfExists('jadwal');
    }
}

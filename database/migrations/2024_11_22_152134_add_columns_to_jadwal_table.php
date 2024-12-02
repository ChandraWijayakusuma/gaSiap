<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToJadwalTable extends Migration
{
    public function up()
    {
        Schema::table('jadwal', function (Blueprint $table) {
            // Cek apakah kolom 'hari' sudah ada sebelum menambahkannya
            if (!Schema::hasColumn('jadwal', 'hari')) {
                $table->string('hari');
            }
    
            if (!Schema::hasColumn('jadwal', 'jam_mulai')) {
                $table->time('jam_mulai');
            }
    
            if (!Schema::hasColumn('jadwal', 'jam_selesai')) {
                $table->time('jam_selesai');
            }
        });
    }
    

    public function down()
    {
        Schema::table('jadwal', function (Blueprint $table) {
            $table->dropColumn(['hari', 'jam_mulai', 'jam_selesai', 'ruangan']);
        });
    }
}
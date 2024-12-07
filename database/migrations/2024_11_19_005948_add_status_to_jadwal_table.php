<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('jadwal', function (Blueprint $table) {
            $table->enum('status', ['Setujui', 'Belum Disetujui'])
                  ->default('Belum Disetujui')
                  ->change(); // Mengubah atau menambahkan kolom status
        });
    }

    public function down()
    {
        Schema::table('jadwal', function (Blueprint $table) {
            $table->string('status')->change(); // Kembalikan ke tipe string jika rollback
        });
    }
};

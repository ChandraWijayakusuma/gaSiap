<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('irs', function (Blueprint $table) {
            // Cek apakah kolom belum ada sebelum menambahkan
            if (!Schema::hasColumn('irs', 'tanggal_persetujuan')) {
                $table->timestamp('tanggal_persetujuan')->nullable();
            }
            
            // Update tipe data status jika belum sesuai
            $table->enum('status', [
                'Belum Disetujui',
                'Menunggu Persetujuan',
                'Disetujui',
                'Ditolak'
            ])->default('Belum Disetujui')->change();
        });
    }

    public function down()
    {
        Schema::table('irs', function (Blueprint $table) {
            if (Schema::hasColumn('irs', 'tanggal_persetujuan')) {
                $table->dropColumn('tanggal_persetujuan');
            }
        });
    }
};
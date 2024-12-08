<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('irs', function (Blueprint $table) {
            // Ubah enum status
            $table->enum('status', [
                'Belum Disetujui',
                'Menunggu Persetujuan',
                'Disetujui',
                'Ditolak'
            ])->default('Belum Disetujui')->change();

            // Tambah kolom tanggal
            $table->timestamp('tanggal_pengajuan')->nullable();
            $table->timestamp('tanggal_persetujuan')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('irs', function (Blueprint $table) {
            $table->enum('status', [
                'Belum Disetujui',
                'Disetujui',
                'Ditolak'
            ])->default('Belum Disetujui')->change();

            $table->dropColumn('tanggal_pengajuan');
            $table->dropColumn('tanggal_persetujuan');
        });
    }
};
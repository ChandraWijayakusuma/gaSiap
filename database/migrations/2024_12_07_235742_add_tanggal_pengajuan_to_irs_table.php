<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('irs', function (Blueprint $table) {
            // Periksa jika kolom 'tanggal_pengajuan' belum ada sebelum menambahkannya
            if (!Schema::hasColumn('irs', 'tanggal_pengajuan')) {
                $table->timestamp('tanggal_pengajuan')->nullable();
            }

            // Periksa jika kolom 'tanggal_persetujuan' belum ada sebelum menambahkannya
            if (!Schema::hasColumn('irs', 'tanggal_persetujuan')) {
                $table->timestamp('tanggal_persetujuan')->nullable();
            }
        });
    }

    public function down()
    {
        Schema::table('irs', function (Blueprint $table) {
            if (Schema::hasColumn('irs', 'tanggal_pengajuan')) {
                $table->dropColumn('tanggal_pengajuan');
            }

            if (Schema::hasColumn('irs', 'tanggal_persetujuan')) {
                $table->dropColumn('tanggal_persetujuan');
            }
        });
    }
};

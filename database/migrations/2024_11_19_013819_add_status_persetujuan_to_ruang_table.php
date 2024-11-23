<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('ruang', function (Blueprint $table) {
            // Tambahkan kolom hanya jika belum ada
            if (!Schema::hasColumn('ruang', 'status_persetujuan')) {
                $table->string('status_persetujuan')->default('Belum Disetujui');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('ruang', function (Blueprint $table) {
            if (Schema::hasColumn('ruang', 'status_persetujuan')) {
                $table->dropColumn('status_persetujuan');
            }
        });
    }
};

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
        Schema::table('irs', function (Blueprint $table) {
            $table->enum('status', [
                'Belum Disetujui',
                'Menunggu Persetujuan',
                'Disetujui',
                'Ditolak'
            ])->default('Belum Disetujui')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};

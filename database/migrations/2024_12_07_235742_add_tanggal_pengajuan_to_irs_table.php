<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('irs', function (Blueprint $table) {
            $table->timestamp('tanggal_pengajuan')->nullable();
            $table->timestamp('tanggal_persetujuan')->nullable();
        });
    }

    public function down()
    {
        Schema::table('irs', function (Blueprint $table) {
            $table->dropColumn('tanggal_pengajuan');
            $table->dropColumn('tanggal_persetujuan');
        });
    }
};
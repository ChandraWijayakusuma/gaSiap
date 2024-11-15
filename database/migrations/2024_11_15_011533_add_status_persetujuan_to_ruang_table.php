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
            $table->string('status_persetujuan')->default('Belum Disetujui')->after('prodi');
        });
    }

    public function down()
    {
        Schema::table('ruang', function (Blueprint $table) {
            $table->dropColumn('status_persetujuan');
        });
    }

};

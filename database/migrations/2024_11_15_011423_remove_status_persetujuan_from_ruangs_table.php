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
    Schema::table('ruangs', function (Blueprint $table) {
        $table->dropColumn('status_persetujuan');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down()
{
    Schema::table('ruangs', function (Blueprint $table) {
        $table->string('status_persetujuan')->default('Belum Disetujui');
    });
}
};

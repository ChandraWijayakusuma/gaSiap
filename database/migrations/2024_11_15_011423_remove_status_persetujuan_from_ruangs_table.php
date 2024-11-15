<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveStatusPersetujuanFromRuangsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        if (Schema::hasColumn('ruang', 'status_persetujuan')) {
            Schema::table('ruang', function (Blueprint $table) {
                $table->dropColumn('status_persetujuan');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('ruang', function (Blueprint $table) {
            if (!Schema::hasColumn('ruang', 'status_persetujuan')) {
                $table->string('status_persetujuan')->default('Belum Disetujui');
            }
        });
    }
}

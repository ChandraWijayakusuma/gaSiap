<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToJadwalTable extends Migration
{
    public function up()
    {
        Schema::table('jadwal', function (Blueprint $table) {
            $table->string('hari');
            $table->time('jam_mulai');
            $table->time('jam_selesai');
            $table->string('ruangan');
        });
    }

    public function down()
    {
        Schema::table('jadwal', function (Blueprint $table) {
            $table->dropColumn(['hari', 'jam_mulai', 'jam_selesai', 'ruangan']);
        });
    }
}
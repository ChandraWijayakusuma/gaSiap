<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateSemesterColumnInMatakuliahTable extends Migration
{
    public function up()
    {
        Schema::table('matakuliah', function (Blueprint $table) {
            // Menjadikan kolom 'semester' nullable atau memberi default value
            $table->integer('semester')->nullable()->change();  // Mengubah menjadi nullable
            // Atau jika Anda ingin memberikan nilai default:
            // $table->integer('semester')->default(1)->change();
        });
    }

    public function down()
    {
        Schema::table('matakuliah', function (Blueprint $table) {
            $table->integer('semester')->nullable(false)->change();
        });
    }
}

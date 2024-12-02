<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIrsTable extends Migration
{
public function up()
{
    Schema::create('i_r_s', function (Blueprint $table) {
        $table->id();
        $table->foreignId('mahasiswa_id')->constrained('users');  // Menghubungkan dengan pengguna (user)
        $table->foreignId('matakuliah_id')->constrained('matakuliah');
        $table->integer('semester');  // Semester yang dipilih
        $table->timestamps();
    });
}


    public function down()
    {
        Schema::dropIfExists('irs');
    }
}

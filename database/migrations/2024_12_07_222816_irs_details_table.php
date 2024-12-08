<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('irs_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('irs_id');
            $table->unsignedBigInteger('mahasiswa_id');
            $table->unsignedBigInteger('matakuliah_id');
            $table->unsignedBigInteger('jadwal_id');
            $table->timestamps();

            $table->foreign('irs_id')->references('id')->on('irs')->onDelete('cascade');
            $table->foreign('mahasiswa_id')->references('id')->on('mahasiswas')->onDelete('cascade');
            $table->foreign('matakuliah_id')->references('id')->on('matakuliah')->onDelete('cascade');
            $table->foreign('jadwal_id')->references('id')->on('jadwal')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('irs_details');
    }
};
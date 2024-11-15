<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ruang extends Model
{
    use HasFactory;

    protected $table = 'ruang'; // Tentukan nama tabel secara eksplisit

    protected $fillable = ['nama_ruang', 'kuota_ruang', 'prodi']; // Kolom yang dapat diisi
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Matakuliah extends Model
{
    use HasFactory;

    protected $table = 'matakuliah'; // Nama tabel
    protected $fillable = ['nama_matakuliah', 'sks']; // Kolom yang boleh diisi
}

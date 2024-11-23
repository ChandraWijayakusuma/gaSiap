<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Matakuliah extends Model
{
    use HasFactory;

    protected $table = 'matakuliah'; // Pastikan nama tabel sudah benar

    protected $fillable = [
        'kode_matakuliah', 
        'nama_matakuliah', 
        'prodi', 
        'sks', 
        'deskripsi',
    ];

    public function jadwal()
    {
        return $this->hasMany(Jadwal::class, 'matakuliah_id');
    }
}

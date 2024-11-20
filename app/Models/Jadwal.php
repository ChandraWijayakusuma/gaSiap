<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    use HasFactory;

    // Tentukan kolom-kolom yang dapat diisi (mass-assignable)
    protected $fillable = [
        'hari',            // Hari (Senin, Selasa, dst.)
        'jam',             // Jam mulai
        'matakuliah_id',   // Foreign key ke tabel matakuliah
        'ruang_id',        // Foreign key ke tabel ruang (untuk ruangan)
        'status',          // Status jadwal (Draft, Pending, Approved, Rejected)
    ];

    // Relasi ke model Matakuliah
    public function matakuliah()
    {
        return $this->belongsTo(Matakuliah::class, 'matakuliah_id'); // Setiap jadwal memiliki satu matakuliah
    }

    // Relasi ke model Ruang
    public function ruang()
    {
        return $this->belongsTo(Ruang::class, 'ruang_id'); // Setiap jadwal memiliki satu ruangan
    }
}

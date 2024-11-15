<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ruang extends Model
{
    use HasFactory;

    protected $table = 'ruang'; // Pastikan ini mengacu pada tabel yang benar

    protected $fillable = [
        'nama_ruang',
        'kuota_ruang',
        'prodi',
        'status_persetujuan', // Tambahkan ini untuk memastikan dapat diisi
    ];
}

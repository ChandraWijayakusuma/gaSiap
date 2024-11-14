<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{

    use HasFactory;

    protected $table = 'kelas';
    protected $fillable = ['kode_kelas', 'nama_kelas', 'kuota'];

    public function departemenKelas()
    {
        return $this->belongsTo(Departemen::class, 'departemen_id');
    }
}

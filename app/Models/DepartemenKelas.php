<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DepartemenKelas extends Model
{
    use HasFactory;

    protected $fillable = ['kelas_id', 'departemen'];

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }
}

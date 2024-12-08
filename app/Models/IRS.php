<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IRS extends Model
{
    protected $table = 'irs';
    
    protected $fillable = [
        'mahasiswa_id',
        'semester',
        'status',
        'tanggal_pengajuan',
        'tanggal_persetujuan'
    ];

    protected $dates = [
        'tanggal_pengajuan',
        'tanggal_persetujuan'
    ];

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class);
    }

    public function details()
    {
        // Explicitly specify the foreign key
        return $this->hasMany(IRSDetail::class, 'irs_id', 'id');
    }
}
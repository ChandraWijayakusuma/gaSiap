<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class IRSDetail extends Model
{
    use HasFactory;

    protected $table = 'irs_details';

    protected $fillable = [
        'irs_id',
        'mahasiswa_id',
        'matakuliah_id',
        'jadwal_id'
    ];

    public function irs(): BelongsTo
    {
        // Explicitly specify the foreign key
        return $this->belongsTo(IRS::class, 'irs_id', 'id');
    }

    public function mahasiswa(): BelongsTo
    {
        return $this->belongsTo(Mahasiswa::class, 'mahasiswa_id');
    }

    public function matakuliah(): BelongsTo
    {
        return $this->belongsTo(Matakuliah::class, 'matakuliah_id');
    }

    public function jadwal(): BelongsTo
    {
        return $this->belongsTo(Jadwal::class, 'jadwal_id');
    }
}
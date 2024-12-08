<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Mahasiswa extends Model
{
    use HasFactory;

    protected $table = 'mahasiswas';

    protected $fillable = [
        'nama',
        'status',
        'semester',
    ];

    /**
     * Get all IRS for the mahasiswa
     */
    public function irs(): HasMany
    {
        return $this->hasMany(IRS::class, 'mahasiswa_id');
    }

    /**
     * Get all IRS details for the mahasiswa
     */
    public function irsDetails(): HasMany
    {
        return $this->hasMany(IRSDetail::class, 'mahasiswa_id');
    }
}
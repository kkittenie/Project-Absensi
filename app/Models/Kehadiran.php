<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo; // Tambahkan ini
use App\Models\Guru; 

class Kehadiran extends Model
{
    protected $table = 'kehadirans'; // Pastikan nama table sesuai, biasanya jamak

    protected $fillable = [
        'guru_id',
        'tanggal',
        'jam_masuk',
        'jam_pulang',
        'lembur_menit',
    ];

    /**
     * Relasi ke model Guru (Many-to-One)
     */
    public function guru(): BelongsTo
    {
        return $this->belongsTo(Guru::class, 'guru_id');
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    protected $table = 'absensis';

    protected $fillable = [
        'uuid',
        'guru_id',
        'tanggal',
        'photo',
        'photo_pulang',
        'latitude',
        'longitude',
        'latitude_pulang',
        'longitude_pulang',
        'status',
        'status_pulang',
        'lembur_menit',
        'selisih_pulang_cepat',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function guru()
    {
        return $this->belongsTo(Guru::class);
    }

    public function kehadiran()
    {
        return $this->hasOne(Kehadiran::class, 'guru_id', 'guru_id')
            ->whereColumn('kehadirans.tanggal', 'absensis.tanggal');
    }
}
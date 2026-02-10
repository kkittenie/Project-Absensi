<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    protected $table = 'absensis';
    protected $fillable = [
        'uuid',
        'guru_id',
        'latitude',
        'longitude',
        'photo',
        'status',
        'waktu_absen'
    ];

    public function guru()
    {
        return $this->belongsTo(Guru::class);
    }
}

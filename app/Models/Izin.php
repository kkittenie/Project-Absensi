<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Izin extends Model
{

    protected $fillable = [
        'guru_id',
        'jenis_izin',
        'tanggal_izin',
        'alasan',
        'foto_surat',
        'status',
    ];

    public function guru()
    {
        return $this->belongsTo(Guru::class, 'guru_id');
    }
}

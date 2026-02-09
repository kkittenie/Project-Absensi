<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Izin extends Model
{
    protected $fillable = [
        'guru_id',
        'jenis_izin',
        'alasan',
        'foto_surat',
        'tanggal_izin',
        'status'
    ];

    public function guru()
    {
        return $this->belongsTo(Guru::class);
    }
}

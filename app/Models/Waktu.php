<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Waktu extends Model
{
    protected $table = 'waktus';

    protected $fillable = [
        'mulai_tap_in',
        'akhir_tap_in',
        'batas_terlambat',
        'mulai_tap_out',
        'akhir_tap_out',
        'hari_libur_mingguan',
    ];

    protected $casts = [
        'hari_libur_mingguan' => 'array',
    ];

    protected $attributes = [
        'hari_libur_mingguan' => '["Sabtu","Minggu"]',
    ];
}
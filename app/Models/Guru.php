<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Guru extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $table = 'gurus';

    protected $fillable = [
        'user_id',
        'uuid',
        'nama_guru',
        'mata_pelajaran',
        'nip',
        'nomor_telepon',
        'photo',
        'is_active',
        'password',
        'role', // ini baru
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // RELASI KE USER
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

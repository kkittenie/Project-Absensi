<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany; // <--- WAJIB TAMBAHKAN INI
use App\Models\Kehadiran;
use App\Models\User;

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
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Kehadiran
    public function kehadiran(): HasMany // Sekarang HasMany sudah dikenali
    {
        return $this->hasMany(Kehadiran::class, 'guru_id');
    }
}
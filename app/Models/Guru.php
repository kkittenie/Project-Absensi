<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Kehadiran;
use App\Models\User;
use App\Models\Izin;
use App\Models\Mapel;
use App\Models\Waktu;

class Guru extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'gurus';

    protected $fillable = [
        'user_id',
        'uuid',
        'nama_guru',
        'email',
        'mapel_id',
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

    /*
    |--------------------------------------------------------------------------
    | RELASI
    |--------------------------------------------------------------------------
    */

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function waktus()
    {
        return $this->hasMany(Waktu::class);
    }

    public function kehadiran(): HasMany
    {
        return $this->hasMany(Kehadiran::class, 'guru_id');
    }

    public function izins()
    {
        return $this->hasMany(Izin::class, 'guru_id');
    }

    public function mapel()
    {
        return $this->belongsTo(Mapel::class);
    }
}
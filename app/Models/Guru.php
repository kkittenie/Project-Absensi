<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Kehadiran;
use App\Models\User;
use App\Models\Izin;
use App\Models\Mapel;

class Guru extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

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

    // Guru milik satu user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Guru punya banyak kehadiran
    public function kehadiran(): HasMany
    {
        return $this->hasMany(Kehadiran::class, 'guru_id');
    }

    // Guru punya banyak izin
    public function izins()
    {
        return $this->hasMany(Izin::class, 'guru_id');
    }

    // Guru punya satu mapel
    public function mapel()
    {
        return $this->belongsTo(Mapel::class);
    }
}
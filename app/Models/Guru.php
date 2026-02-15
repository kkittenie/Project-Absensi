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

    // relasi
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function mapel()
    {
        return $this->belongsTo(Mapel::class);
    }
}

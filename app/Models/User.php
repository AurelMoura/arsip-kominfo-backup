<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Daftarkan kolom yang boleh diisi secara massal.
     * Ini akan menggantikan penggunaan #[Fillable] yang tadi error.
     */
    protected $fillable = [
        'name',
        'pegawai_id',
        'jabatan',
        'bidang',
        'no_hp',
        'alamat',
        'password',
        'role',
        'is_first_login',
        'profil_dasar_lengkap',
        'password_change_count',
        'is_active',
        'last_login_at',
        'last_password_change',
    ];

    /**
     * Sembunyikan data sensitif saat dipanggil.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Pengaturan tipe data (Casting).
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'profil_dasar_lengkap' => 'boolean',
            'is_active' => 'boolean',
            'last_password_change' => 'datetime',
            'last_login_at' => 'datetime',
        ];
    }

    public function documents(): HasMany
    {
        return $this->hasMany(Document::class);
    }

    public function pegawai(): HasOne
    {
        return $this->hasOne(Pegawai::class, 'id', 'pegawai_id');
    }
}
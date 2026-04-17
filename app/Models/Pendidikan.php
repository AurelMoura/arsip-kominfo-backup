<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pendidikan extends Model
{
    use HasFactory;

    protected $table = 'pendidikans'; // Nama tabel di database
    protected $fillable = ['nama', 'aktif'];

    // Relasi ke Riwayat Pendidikan (Satu jenjang punya banyak riwayat)
    public function riwayat_pendidikan()
    {
        return $this->hasMany(RiwayatPendidikan::class, 'pendidikan_id');
    }

    /**
     * ASN yang memiliki riwayat pendidikan ini.
     * Join melalui tabel riwayat_pendidikans.
     */
    public function pegawais()
    {
        return $this->hasManyThrough(
            Pegawai::class,
            RiwayatPendidikan::class,
            'pendidikan_id',
            'id',
            'id',
            'pegawai_id'
        )->distinct();
    }
}

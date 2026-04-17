<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pangkat extends Model
{
    protected $table = 'pangkats';

    protected $fillable = [
        'nama',
        'golongan',
        'jenis_asn',
        'aktif'
    ];

    protected function casts(): array
    {
        return [
            'aktif' => 'string'
        ];
    }

    // Relationship dengan RiwayatJabatan
    public function riwayatJabatans()
    {
        return $this->hasMany(RiwayatJabatan::class, 'pangkat_id', 'id');
    }

    /**
     * ASN dengan pangkat/golongan ini.
     * Join berdasarkan kolom golongan_pangkat di tabel pegawai.
     */
    public function pegawais()
    {
        return $this->hasMany(Pegawai::class, 'golongan_pangkat', 'golongan');
    }
}
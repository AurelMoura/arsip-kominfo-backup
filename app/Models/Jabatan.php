<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jabatan extends Model
{
    protected $table = 'jabatans';

    protected $fillable = [
        'jenis_jabatan',
        'nama_jabatan',
        'jenis_asn',
        'golongan',
        'eselon',
        'aktif',
    ];

    protected function casts(): array
    {
        return [
            'aktif' => 'string'
        ];
    }

    /**
     * ASN yang saat ini menjabat posisi ini.
     * Join berdasarkan nama_jabatan (denormalized) di tabel pegawai.
     */
    public function pegawais()
    {
        return $this->hasMany(Pegawai::class, 'nama_jabatan', 'nama_jabatan');
    }
}
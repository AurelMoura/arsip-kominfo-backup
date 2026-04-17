<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Agama extends Model
{
    protected $table = 'agama';

    protected $fillable = [
        'nama',
        'aktif'
    ];

    protected function casts(): array
    {
        return [
            'aktif' => 'string'
        ];
    }

    /**
     * ASN yang terdaftar dengan agama ini.
     * Join berdasarkan nama agama (denormalized) di tabel pegawai.
     */
    public function pegawais()
    {
        return $this->hasMany(Pegawai::class, 'nama_agama', 'nama');
    }

}

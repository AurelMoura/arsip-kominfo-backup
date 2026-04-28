<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UnitKerja extends Model
{
    protected $table = 'unit_kerjas';

    protected $fillable = [
        'name'
    ];

    protected function casts(): array
    {
        return [];
    }

    // Relationship dengan RiwayatJabatan
    public function riwayatJabatans()
    {
        return $this->hasMany(RiwayatJabatan::class, 'unit_kerja_id', 'id');
    }

    // Sumber utama ASN pada master unit kerja
    public function pegawais()
    {
        return $this->hasMany(Pegawai::class, 'unit_kerja_id', 'id');
    }
}

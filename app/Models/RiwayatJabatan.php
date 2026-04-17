<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatJabatan extends Model
{
    use HasFactory;

    protected $table = 'riwayat_jabatans';
    protected $fillable = [
        'pegawai_id',
        'nama_pegawai',
        'pangkat_id',
        'jabatan_id',
        'eselon_id',
        'jenis_jabatan',
        'nama_jabatan',
        'eselon',
        'unit_kerja_id',
        'tmt',
        'no_sk',
        'dokumen'
    ];

    // Relasi: Riwayat ini merujuk ke satu Pangkat
    public function pangkat()
    {
        return $this->belongsTo(Pangkat::class, 'pangkat_id');
    }

    // Relasi: Riwayat ini merujuk ke satu Jabatan
    public function jabatan()
    {
        return $this->belongsTo(Jabatan::class, 'jabatan_id');
    }

    // Relasi: Riwayat ini merujuk ke satu Eselon
    public function eselon()
    {
        return $this->belongsTo(Eselon::class, 'eselon_id');
    }
    public function unit_kerja()
    {
        return $this->belongsTo(UnitKerja::class, 'unit_kerja_id');
    }

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'pegawai_id');
    }
}
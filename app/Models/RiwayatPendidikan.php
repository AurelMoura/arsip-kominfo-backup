<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatPendidikan extends Model
{
    use HasFactory;

    protected $table = 'riwayat_pendidikans';
    protected $fillable = [
        'pegawai_id',
        'nama_pegawai',
        'pendidikan_id',
        'nama_instansi',
        'tahun_masuk',
        'tahun_keluar',
        'no_ijazah',
        'nama_pejabat',
        'dokumen'
    ];

    // Relasi balik ke Master Pendidikan
    public function pendidikan()
    {
        return $this->belongsTo(Pendidikan::class, 'pendidikan_id');
    }

    // Relasi ke Pegawai
    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'pegawai_id');
    }
}

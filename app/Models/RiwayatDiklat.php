<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatDiklat extends Model
{
    use HasFactory;

    protected $table = 'riwayat_diklats';
    protected $fillable = [
        'pegawai_id',
        'nama_pegawai',
        'nama_diklat',
        'penyelenggara',
        'no_sertifikat',
        'tahun',
        'dokumen'
    ];

    // Relasi balik ke Pegawai
    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'pegawai_id');
    }
}
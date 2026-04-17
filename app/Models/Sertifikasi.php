<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sertifikasi extends Model
{
    protected $table = 'sertifikasis';
    
    protected $fillable = ['pegawai_id', 'nama_pegawai', 'nama_sertifikasi', 'tahun', 'lembaga_pelaksana', 'dokumen'];

    public function pegawai() {
        return $this->belongsTo(Pegawai::class, 'pegawai_id');
    }
}

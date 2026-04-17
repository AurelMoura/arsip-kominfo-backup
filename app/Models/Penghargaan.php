<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penghargaan extends Model
{
    protected $table = 'penghargaans';
    protected $fillable = [
        'pegawai_id',
        'nama_pegawai',
        'nama_penghargaan',
        'tahun',
        'instansi_pemberi',
        'dokumen'
    ];

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'pegawai_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IdentitasLegal extends Model
{
    protected $table = 'identitas_legals';

    protected $fillable = [
        'pegawai_id',
        'nama_pegawai',
        'no_ktp',
        'no_npwp',
        'no_bpjs',
        'no_kk',
        'dok_ktp',
        'dok_npwp',
        'dok_bpjs',
        'dok_kk',
        'is_locked_legal',
    ];

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'pegawai_id', 'id');
    }
}

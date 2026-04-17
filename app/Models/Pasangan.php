<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pasangan extends Model
{
    protected $table = 'pasangans';

    protected $fillable = [
        'pegawai_id',
        'nama_pegawai',
        'nik',
        'nama',
        'status',
        'status_hidup',
        'tempat_lahir',
        'tanggal_lahir',
        'pekerjaan',
        'no_akta_nikah',
        'aktif',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
    ];

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'pegawai_id', 'id');
    }
}

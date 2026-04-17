<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Saudara extends Model
{
    protected $table = 'saudaras';

    protected $fillable = [
        'pegawai_id',
        'nama_pegawai',
        'nik',
        'nama',
        'jenis_kelamin',
        'tanggal_lahir',
        'pekerjaan',
        'status_hub',
        'status_kawin',
        'file',
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

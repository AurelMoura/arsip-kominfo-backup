<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Anak extends Model
{
    protected $table = 'anaks';

    protected $fillable = [
        'pegawai_id',
        'nama_pegawai',
        'nik',
        'nama',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'pekerjaan',
        'status_anak',
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

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mertua extends Model
{
    protected $table = 'mertuas';

    protected $fillable = [
        'pegawai_id',
        'nama_pegawai',
        'nik',
        'nama',
        'tempat_lahir',
        'tanggal_lahir',
        'pekerjaan',
        'status_hub',
        'status_hidup',
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

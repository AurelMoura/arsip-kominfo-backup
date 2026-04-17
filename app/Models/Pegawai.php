<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    // Nama tabel (opsional, tapi kita tulis biar jelas)
    protected $table = 'pegawai';

    // Primary key
    protected $primaryKey = 'id';

    // Karena bukan auto increment
    public $incrementing = false;

    // Tipe primary key (char/string)
    protected $keyType = 'string';

    // Field yang boleh diisi (mass assignment)
    protected $fillable = [
        'id',
        'foto_profil',
        'nama_lengkap',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'gol_darah',
        'status_kawin',
        'status_pegawai',
        'email',
        'no_hp',
        'no_kk',
        'no_nik',
        'no_bpjs',
        'no_taspen',
        'tmt',
        'unit_kerja_id',
        'dok_kk',
        'dok_ktp',
        'dok_akte',
        'dok_nikah',

        // Kolom agama & pangkat detail
        'nama_agama',
        'nama_pangkat',
        'golongan_pangkat',
        // Kolom jabatan detail
        'jenis_jabatan',
        'nama_jabatan',
        'eselon_jabatan',
        'tmt_jabatan',
        // Kolom DRH
        'data_keluarga',
        'dokumen_pendukung',
        'drh_lengkap'
    ];

    // Casting untuk kolom
    protected function casts(): array
    {
        return [
            'tanggal_lahir' => 'date',
            'tmt' => 'date',
            'tmt_jabatan' => 'date',
            // Casting kolom JSON DRH
            'data_keluarga' => 'array',
            'dokumen_pendukung' => 'array',
            'drh_lengkap' => 'boolean'
        ];
    }

    // Relationships
    public function unit_kerja()
    {
        return $this->belongsTo(UnitKerja::class, 'unit_kerja_id');
    }

    public function pasangan()
    {
        return $this->hasOne(Pasangan::class, 'pegawai_id', 'id');
    }

    public function anaks()
    {
        return $this->hasMany(Anak::class, 'pegawai_id', 'id');
    }

    public function orangTuas()
    {
        return $this->hasMany(OrangTua::class, 'pegawai_id', 'id');
    }

    public function mertuas()
    {
        return $this->hasMany(Mertua::class, 'pegawai_id', 'id');
    }

    public function saudaras()
    {
        return $this->hasMany(Saudara::class, 'pegawai_id', 'id');
    }

    public function riwayatPendidikans()
    {
        return $this->hasMany(RiwayatPendidikan::class, 'pegawai_id', 'id');
    }

    public function riwayatDiklats()
    {
        return $this->hasMany(RiwayatDiklat::class, 'pegawai_id', 'id');
    }

    public function riwayatJabatans()
    {
        return $this->hasMany(RiwayatJabatan::class, 'pegawai_id', 'id');
    }

    public function penghargaans()
    {
        return $this->hasMany(Penghargaan::class, 'pegawai_id', 'id');
    }

    public function sertifikasis()
    {
        return $this->hasMany(Sertifikasi::class, 'pegawai_id', 'id');
    }

    public function identitasLegal()
    {
        return $this->hasOne(IdentitasLegal::class, 'pegawai_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id', 'pegawai_id');
    }

    /**
     * Relasi: Pegawai bisa mengakses documents melalui User
     */
    public function documents()
    {
        return $this->hasManyThrough(
            Document::class,
            User::class,
            'pegawai_id',  // Foreign key pada users table
            'user_id',     // Foreign key pada documents table
            'id',          // Local key pada pegawai table
            'id'           // Local key pada users table
        );
    }
}
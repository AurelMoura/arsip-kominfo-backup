<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasterSertifikasi extends Model
{
    protected $fillable = ['nama_sertifikasi', 'tahun', 'lembaga_pemberi'];
}

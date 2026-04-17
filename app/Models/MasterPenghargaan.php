<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasterPenghargaan extends Model
{
    protected $fillable = ['nama_penghargaan', 'tahun', 'instansi_pemberi'];
}

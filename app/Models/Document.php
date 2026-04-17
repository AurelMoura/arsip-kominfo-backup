<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    protected $table = 'documents';

    protected $fillable = [
        'user_id',
        'nama_pegawai',
        'title',
        'original_name',
        'file_path',
        'mime_type',
        'file_size',
        'uploaded_at',
        'status',
        'rejection_reason',
        'is_active',
    ];

    protected $casts = [
        'uploaded_at' => 'datetime',
        'file_size' => 'integer',
        'is_active' => 'boolean',
    ];

    /**
     * Relasi: Dokumen dimiliki oleh satu User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

// ...existing code...

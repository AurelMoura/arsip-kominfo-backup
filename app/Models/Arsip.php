<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Arsip extends Model
{
    protected $fillable = [
        'nama',
        'aktif',
    ];

    public function documents(): HasMany
    {
        return $this->hasMany(Document::class);
    }
}

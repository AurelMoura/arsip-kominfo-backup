<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE jabatans MODIFY COLUMN jenis_jabatan VARCHAR(100) NULL");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE jabatans MODIFY COLUMN jenis_jabatan ENUM('struktural','fungsional','Struktural','JFT','JFU') NULL");
    }
};

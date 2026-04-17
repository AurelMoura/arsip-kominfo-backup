<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Step 1: Expand ENUM to include all values temporarily
        DB::statement("ALTER TABLE jabatans MODIFY COLUMN jenis_jabatan ENUM('struktural','fungsional','JFU','JFT') NOT NULL");

        // Step 2: Convert existing 'fungsional' to 'JFT'
        DB::table('jabatans')->where('jenis_jabatan', 'fungsional')->update(['jenis_jabatan' => 'JFT']);

        // Step 3: Now remove 'fungsional' from ENUM
        DB::statement("ALTER TABLE jabatans MODIFY COLUMN jenis_jabatan ENUM('struktural','JFU','JFT') NOT NULL");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE jabatans MODIFY COLUMN jenis_jabatan ENUM('struktural','fungsional','JFU','JFT') NOT NULL");

        DB::table('jabatans')->where('jenis_jabatan', 'JFT')->update(['jenis_jabatan' => 'fungsional']);
        DB::table('jabatans')->where('jenis_jabatan', 'JFU')->update(['jenis_jabatan' => 'fungsional']);

        DB::statement("ALTER TABLE jabatans MODIFY COLUMN jenis_jabatan ENUM('struktural','fungsional') NOT NULL");
    }
};

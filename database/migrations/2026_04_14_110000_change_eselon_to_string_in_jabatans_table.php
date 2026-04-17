<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE jabatans MODIFY COLUMN eselon VARCHAR(50) NULL");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE jabatans MODIFY COLUMN eselon ENUM('II.a','II.b','III.a','III.b','IV.a','IV.b') NULL");
    }
};

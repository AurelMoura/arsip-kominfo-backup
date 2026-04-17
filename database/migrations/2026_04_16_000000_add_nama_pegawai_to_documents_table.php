<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('documents', function (Blueprint $table) {
            // Add missing columns to documents table
            if (!Schema::hasColumn('documents', 'nama_pegawai')) {
                $table->string('nama_pegawai', 255)->nullable()->after('user_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('documents', function (Blueprint $table) {
            if (Schema::hasColumn('documents', 'nama_pegawai')) {
                $table->dropColumn('nama_pegawai');
            }
        });
    }
};

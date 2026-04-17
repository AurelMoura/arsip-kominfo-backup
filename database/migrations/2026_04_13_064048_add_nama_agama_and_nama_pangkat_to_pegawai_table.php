<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pegawai', function (Blueprint $table) {
            if (!Schema::hasColumn('pegawai', 'nama_agama')) {
                $table->string('nama_agama', 50)->nullable()->after('agama_id');
            }
            if (!Schema::hasColumn('pegawai', 'nama_pangkat')) {
                $table->string('nama_pangkat', 50)->nullable()->after('pangkat_id');
            }
            if (!Schema::hasColumn('pegawai', 'golongan_pangkat')) {
                $table->string('golongan_pangkat', 10)->nullable()->after('nama_pangkat');
            }
        });

        // Backfill from related tables
        DB::statement("
            UPDATE pegawai p
            LEFT JOIN agama a ON p.agama_id = a.id
            LEFT JOIN pangkats pk ON p.pangkat_id = pk.id
            SET p.nama_agama = a.nama,
                p.nama_pangkat = pk.nama,
                p.golongan_pangkat = pk.golongan
        ");
    }

    public function down(): void
    {
        Schema::table('pegawai', function (Blueprint $table) {
            $table->dropColumn(['nama_agama', 'nama_pangkat', 'golongan_pangkat']);
        });
    }
};

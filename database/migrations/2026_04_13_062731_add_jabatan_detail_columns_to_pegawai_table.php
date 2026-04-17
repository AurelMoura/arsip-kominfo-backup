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
            if (!Schema::hasColumn('pegawai', 'jenis_jabatan')) {
                $table->string('jenis_jabatan', 20)->nullable()->after('jabatan_id');
            }
            if (!Schema::hasColumn('pegawai', 'nama_jabatan')) {
                $table->string('nama_jabatan', 100)->nullable()->after('jenis_jabatan');
            }
            if (!Schema::hasColumn('pegawai', 'eselon_jabatan')) {
                $table->string('eselon_jabatan', 10)->nullable()->after('nama_jabatan');
            }
        });

        // Backfill existing data from jabatans table
        DB::statement("
            UPDATE pegawai p
            INNER JOIN jabatans j ON p.jabatan_id = j.id
            SET p.jenis_jabatan = j.jenis_jabatan,
                p.nama_jabatan = j.nama_jabatan,
                p.eselon_jabatan = j.eselon
        ");
    }

    public function down(): void
    {
        Schema::table('pegawai', function (Blueprint $table) {
            $table->dropColumn(['jenis_jabatan', 'nama_jabatan', 'eselon_jabatan']);
        });
    }
};

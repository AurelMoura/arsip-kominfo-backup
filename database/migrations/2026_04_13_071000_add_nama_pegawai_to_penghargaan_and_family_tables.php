<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $tables = ['penghargaans', 'mertuas', 'anaks', 'saudaras', 'pasangans'];

        foreach ($tables as $table) {
            if (!Schema::hasColumn($table, 'nama_pegawai')) {
                Schema::table($table, function (Blueprint $blueprint) {
                    $blueprint->string('nama_pegawai', 100)->nullable()->after('pegawai_id');
                });

                DB::statement("
                    UPDATE {$table} t
                    INNER JOIN pegawai p ON t.pegawai_id = p.id
                    SET t.nama_pegawai = p.nama_lengkap
                ");
            }
        }
    }

    public function down(): void
    {
        $tables = ['penghargaans', 'mertuas', 'anaks', 'saudaras', 'pasangans'];

        foreach ($tables as $table) {
            if (Schema::hasColumn($table, 'nama_pegawai')) {
                Schema::table($table, function (Blueprint $blueprint) {
                    $blueprint->dropColumn('nama_pegawai');
                });
            }
        }
    }
};

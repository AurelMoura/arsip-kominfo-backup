<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tambah kolom yang hilang di saudaras
        if (Schema::hasTable('saudaras')) {
            Schema::table('saudaras', function (Blueprint $table) {
                // Jika belum ada, tambahkan
                if (!Schema::hasColumn('saudaras', 'nik')) {
                    $table->string('nik', 20)->nullable()->after('pegawai_id');
                }
                if (!Schema::hasColumn('saudaras', 'file')) {
                    $table->string('file', 150)->nullable()->after('pekerjaan');
                }
                if (!Schema::hasColumn('saudaras', 'status_kawin')) {
                    $table->string('status_kawin', 50)->nullable()->after('status_hub');
                }
            });
        }

        // Pastikan kolom di orang_tuas
        if (Schema::hasTable('orang_tuas')) {
            Schema::table('orang_tuas', function (Blueprint $table) {
                if (!Schema::hasColumn('orang_tuas', 'file')) {
                    $table->string('file', 150)->nullable();
                }
            });
        }

        // Pastikan kolom di pasangans
        if (Schema::hasTable('pasangans')) {
            Schema::table('pasangans', function (Blueprint $table) {
                if (!Schema::hasColumn('pasangans', 'file')) {
                    $table->string('file', 150)->nullable();
                }
            });
        }

        // Pastikan kolom di anaks
        if (Schema::hasTable('anaks')) {
            Schema::table('anaks', function (Blueprint $table) {
                if (!Schema::hasColumn('anaks', 'file')) {
                    $table->string('file', 150)->nullable();
                }
            });
        }
    }

    public function down(): void
    {
        //
    }
};

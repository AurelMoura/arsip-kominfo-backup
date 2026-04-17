<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // === 1. Drop agama_id, pangkat_id, jabatan_id, eselon_id dari tabel pegawai ===
        Schema::table('pegawai', function (Blueprint $table) {
            // Drop foreign keys dulu
            if (Schema::hasColumn('pegawai', 'agama_id')) {
                try { $table->dropForeign(['agama_id']); } catch (\Exception $e) {}
            }
            if (Schema::hasColumn('pegawai', 'pangkat_id')) {
                try { $table->dropForeign(['pangkat_id']); } catch (\Exception $e) {}
            }
            if (Schema::hasColumn('pegawai', 'jabatan_id')) {
                try { $table->dropForeign(['jabatan_id']); } catch (\Exception $e) {}
            }
            if (Schema::hasColumn('pegawai', 'eselon_id')) {
                try { $table->dropForeign(['eselon_id']); } catch (\Exception $e) {}
            }
        });

        Schema::table('pegawai', function (Blueprint $table) {
            $columns = [];
            if (Schema::hasColumn('pegawai', 'agama_id')) $columns[] = 'agama_id';
            if (Schema::hasColumn('pegawai', 'pangkat_id')) $columns[] = 'pangkat_id';
            if (Schema::hasColumn('pegawai', 'jabatan_id')) $columns[] = 'jabatan_id';
            if (Schema::hasColumn('pegawai', 'eselon_id')) $columns[] = 'eselon_id';
            if (!empty($columns)) {
                $table->dropColumn($columns);
            }
        });

        // === 2. Tambah nama_pegawai ke tabel riwayat_pendidikans ===
        if (!Schema::hasColumn('riwayat_pendidikans', 'nama_pegawai')) {
            Schema::table('riwayat_pendidikans', function (Blueprint $table) {
                $table->string('nama_pegawai', 100)->nullable()->after('pegawai_id');
            });
            // Backfill
            DB::statement("
                UPDATE riwayat_pendidikans rp
                INNER JOIN pegawai p ON rp.pegawai_id = p.id
                SET rp.nama_pegawai = p.nama_lengkap
            ");
        }

        // === 3. Tambah nama_pegawai ke tabel riwayat_jabatans ===
        if (!Schema::hasColumn('riwayat_jabatans', 'nama_pegawai')) {
            Schema::table('riwayat_jabatans', function (Blueprint $table) {
                $table->string('nama_pegawai', 100)->nullable()->after('pegawai_id');
            });
            DB::statement("
                UPDATE riwayat_jabatans rj
                INNER JOIN pegawai p ON rj.pegawai_id = p.id
                SET rj.nama_pegawai = p.nama_lengkap
            ");
        }

        // === 4. Tambah nama_pegawai ke tabel riwayat_diklats ===
        if (!Schema::hasColumn('riwayat_diklats', 'nama_pegawai')) {
            Schema::table('riwayat_diklats', function (Blueprint $table) {
                $table->string('nama_pegawai', 100)->nullable()->after('pegawai_id');
            });
            DB::statement("
                UPDATE riwayat_diklats rd
                INNER JOIN pegawai p ON rd.pegawai_id = p.id
                SET rd.nama_pegawai = p.nama_lengkap
            ");
        }

        // === 5. Tambah nama_pegawai ke tabel sertifikasis ===
        if (!Schema::hasColumn('sertifikasis', 'nama_pegawai')) {
            Schema::table('sertifikasis', function (Blueprint $table) {
                $table->string('nama_pegawai', 100)->nullable()->after('pegawai_id');
            });
            DB::statement("
                UPDATE sertifikasis s
                INNER JOIN pegawai p ON s.pegawai_id = p.id
                SET s.nama_pegawai = p.nama_lengkap
            ");
        }
    }

    public function down(): void
    {
        // Kembalikan kolom FK ke pegawai
        Schema::table('pegawai', function (Blueprint $table) {
            if (!Schema::hasColumn('pegawai', 'agama_id')) {
                $table->unsignedBigInteger('agama_id')->nullable();
            }
            if (!Schema::hasColumn('pegawai', 'pangkat_id')) {
                $table->unsignedInteger('pangkat_id')->nullable();
            }
            if (!Schema::hasColumn('pegawai', 'jabatan_id')) {
                $table->unsignedInteger('jabatan_id')->nullable();
            }
            if (!Schema::hasColumn('pegawai', 'eselon_id')) {
                $table->unsignedInteger('eselon_id')->nullable();
            }
        });

        // Hapus nama_pegawai dari tabel riwayat
        Schema::table('riwayat_pendidikans', function (Blueprint $table) {
            if (Schema::hasColumn('riwayat_pendidikans', 'nama_pegawai')) {
                $table->dropColumn('nama_pegawai');
            }
        });
        Schema::table('riwayat_jabatans', function (Blueprint $table) {
            if (Schema::hasColumn('riwayat_jabatans', 'nama_pegawai')) {
                $table->dropColumn('nama_pegawai');
            }
        });
        Schema::table('riwayat_diklats', function (Blueprint $table) {
            if (Schema::hasColumn('riwayat_diklats', 'nama_pegawai')) {
                $table->dropColumn('nama_pegawai');
            }
        });
        Schema::table('sertifikasis', function (Blueprint $table) {
            if (Schema::hasColumn('sertifikasis', 'nama_pegawai')) {
                $table->dropColumn('nama_pegawai');
            }
        });
    }
};

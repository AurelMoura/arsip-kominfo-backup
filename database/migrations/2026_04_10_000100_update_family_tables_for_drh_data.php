<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pasangans', function (Blueprint $table) {
            if (!Schema::hasColumn('pasangans', 'nik')) {
                $table->string('nik', 16)->nullable()->after('pegawai_id');
            }
            if (!Schema::hasColumn('pasangans', 'status')) {
                $table->enum('status', ['SUAMI', 'ISTRI'])->nullable()->after('nama');
            }
            if (!Schema::hasColumn('pasangans', 'status_hidup')) {
                $table->enum('status_hidup', ['Hidup', 'Meninggal'])->nullable()->after('status');
            }
            if (!Schema::hasColumn('pasangans', 'file')) {
                $table->string('file', 150)->nullable()->after('pekerjaan');
            }
            if (Schema::hasColumn('pasangans', 'tempat_lahir')) {
                $table->string('tempat_lahir', 50)->nullable()->change();
            }
            if (Schema::hasColumn('pasangans', 'tanggal_lahir')) {
                $table->date('tanggal_lahir')->nullable()->change();
            }
        });

        Schema::table('anaks', function (Blueprint $table) {
            if (!Schema::hasColumn('anaks', 'nik')) {
                $table->string('nik', 16)->nullable()->after('pegawai_id');
            }
            if (!Schema::hasColumn('anaks', 'status_anak')) {
                $table->enum('status_anak', ['Kandung', 'Tiri', 'Angkat'])->nullable()->after('jenis_kelamin');
            }
            if (!Schema::hasColumn('anaks', 'status_kawin')) {
                $table->enum('status_kawin', ['Belum Menikah', 'Menikah', 'Cerai Hidup', 'Cerai Mati'])->nullable()->after('status_anak');
            }
            if (!Schema::hasColumn('anaks', 'file')) {
                $table->string('file', 150)->nullable()->after('pekerjaan');
            }
            if (Schema::hasColumn('anaks', 'jenis_kelamin')) {
                $table->enum('jenis_kelamin', ['L', 'P'])->nullable()->change();
            }
            if (Schema::hasColumn('anaks', 'tempat_lahir')) {
                $table->string('tempat_lahir', 50)->nullable()->change();
            }
            if (Schema::hasColumn('anaks', 'tanggal_lahir')) {
                $table->date('tanggal_lahir')->nullable()->change();
            }
        });

        Schema::table('orang_tuas', function (Blueprint $table) {
            if (!Schema::hasColumn('orang_tuas', 'nik')) {
                $table->string('nik', 16)->nullable()->after('pegawai_id');
            }
            if (!Schema::hasColumn('orang_tuas', 'alamat')) {
                $table->string('alamat', 255)->nullable()->after('nama');
            }
            if (!Schema::hasColumn('orang_tuas', 'status_hidup')) {
                $table->enum('status_hidup', ['Hidup', 'Meninggal'])->nullable()->after('status_hub');
            }
            if (!Schema::hasColumn('orang_tuas', 'file')) {
                $table->string('file', 150)->nullable()->after('pekerjaan');
            }
            if (Schema::hasColumn('orang_tuas', 'tempat_lahir')) {
                $table->string('tempat_lahir', 50)->nullable()->change();
            }
            if (Schema::hasColumn('orang_tuas', 'tanggal_lahir')) {
                $table->date('tanggal_lahir')->nullable()->change();
            }
        });

        Schema::table('mertuas', function (Blueprint $table) {
            if (!Schema::hasColumn('mertuas', 'nik')) {
                $table->string('nik', 16)->nullable()->after('pegawai_id');
            }
            if (!Schema::hasColumn('mertuas', 'status_hidup')) {
                $table->enum('status_hidup', ['Hidup', 'Meninggal'])->nullable()->after('status_hub');
            }
            if (!Schema::hasColumn('mertuas', 'file')) {
                $table->string('file', 150)->nullable()->after('pekerjaan');
            }
            if (Schema::hasColumn('mertuas', 'tempat_lahir')) {
                $table->string('tempat_lahir', 50)->nullable()->change();
            }
            if (Schema::hasColumn('mertuas', 'tanggal_lahir')) {
                $table->date('tanggal_lahir')->nullable()->change();
            }
        });

        Schema::table('saudaras', function (Blueprint $table) {
            if (!Schema::hasColumn('saudaras', 'nik')) {
                $table->string('nik', 16)->nullable()->after('pegawai_id');
            }
            if (!Schema::hasColumn('saudaras', 'status_kawin')) {
                $table->enum('status_kawin', ['Belum Menikah', 'Menikah', 'Cerai Hidup', 'Cerai Mati'])->nullable()->after('status_hub');
            }
            if (Schema::hasColumn('saudaras', 'jenis_kelamin')) {
                $table->enum('jenis_kelamin', ['L', 'P'])->nullable()->change();
            }
            if (Schema::hasColumn('saudaras', 'tempat_lahir')) {
                $table->string('tempat_lahir', 50)->nullable()->change();
            }
            if (Schema::hasColumn('saudaras', 'tanggal_lahir')) {
                $table->date('tanggal_lahir')->nullable()->change();
            }
            if (Schema::hasColumn('saudaras', 'status_hub')) {
                $table->string('status_hub', 50)->nullable()->change();
            }
        });
    }

    public function down(): void
    {
        Schema::table('pasangans', function (Blueprint $table) {
            if (Schema::hasColumn('pasangans', 'nik')) {
                $table->dropColumn('nik');
            }
            if (Schema::hasColumn('pasangans', 'status')) {
                $table->dropColumn('status');
            }
            if (Schema::hasColumn('pasangans', 'status_hidup')) {
                $table->dropColumn('status_hidup');
            }
            if (Schema::hasColumn('pasangans', 'file')) {
                $table->dropColumn('file');
            }
        });

        Schema::table('anaks', function (Blueprint $table) {
            if (Schema::hasColumn('anaks', 'nik')) {
                $table->dropColumn('nik');
            }
            if (Schema::hasColumn('anaks', 'status_anak')) {
                $table->dropColumn('status_anak');
            }
            if (Schema::hasColumn('anaks', 'status_kawin')) {
                $table->dropColumn('status_kawin');
            }
            if (Schema::hasColumn('anaks', 'file')) {
                $table->dropColumn('file');
            }
        });

        Schema::table('orang_tuas', function (Blueprint $table) {
            if (Schema::hasColumn('orang_tuas', 'nik')) {
                $table->dropColumn('nik');
            }
            if (Schema::hasColumn('orang_tuas', 'alamat')) {
                $table->dropColumn('alamat');
            }
            if (Schema::hasColumn('orang_tuas', 'status_hidup')) {
                $table->dropColumn('status_hidup');
            }
            if (Schema::hasColumn('orang_tuas', 'file')) {
                $table->dropColumn('file');
            }
        });

        Schema::table('mertuas', function (Blueprint $table) {
            if (Schema::hasColumn('mertuas', 'nik')) {
                $table->dropColumn('nik');
            }
            if (Schema::hasColumn('mertuas', 'status_hidup')) {
                $table->dropColumn('status_hidup');
            }
            if (Schema::hasColumn('mertuas', 'file')) {
                $table->dropColumn('file');
            }
        });

        Schema::table('saudaras', function (Blueprint $table) {
            if (Schema::hasColumn('saudaras', 'nik')) {
                $table->dropColumn('nik');
            }
            if (Schema::hasColumn('saudaras', 'status_kawin')) {
                $table->dropColumn('status_kawin');
            }
        });
    }
};

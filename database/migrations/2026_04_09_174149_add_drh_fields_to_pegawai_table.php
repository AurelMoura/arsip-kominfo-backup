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
        Schema::table('pegawai', function (Blueprint $table) {
            // Data keluarga (pasangan, anak, orang tua, mertua)
            $table->json('data_keluarga')->nullable();

            // Riwayat pendidikan
            $table->json('riwayat_pendidikan')->nullable();

            // Riwayat diklat
            $table->json('riwayat_diklat')->nullable();

            // Riwayat jabatan
            $table->json('riwayat_jabatan')->nullable();

            // Riwayat penghargaan
            $table->json('riwayat_penghargaan')->nullable();

            // Riwayat sertifikasi
            $table->json('riwayat_sertifikasi')->nullable();

            // Identitas legal (KTP, NPWP, BPJS, KK)
            $table->json('identitas_legal')->nullable();

            // Dokumen pendukung
            $table->json('dokumen_pendukung')->nullable();

            // Status kelengkapan DRH
            $table->boolean('drh_lengkap')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pegawai', function (Blueprint $table) {
            $table->dropColumn([
                'data_keluarga',
                'riwayat_pendidikan',
                'riwayat_diklat',
                'riwayat_jabatan',
                'riwayat_penghargaan',
                'riwayat_sertifikasi',
                'identitas_legal',
                'dokumen_pendukung',
                'drh_lengkap'
            ]);
        });
    }
};

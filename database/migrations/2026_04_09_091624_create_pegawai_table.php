<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pegawai', function (Blueprint $table) {

            // Primary Key (NIP)
            $table->char('id', 18)->primary();

            // Data utama
            $table->string('nama_lengkap', 100);
            $table->enum('jenis_kelamin', ['P', 'L'])->index();
            $table->string('tempat_lahir', 100);
            $table->date('tanggal_lahir')->nullable();

            // --- BAGIAN RELASI (FOREIGN KEY) ---
            // Kita pakai unsignedBigInteger untuk agama (karena agama.id menggunakan id() = BIGINT UNSIGNED)
            // unsignedInteger untuk pangkat dan jabatan (karena mereka pakai increments() = INT UNSIGNED)
            $table->unsignedBigInteger('agama_id')->index();
            $table->unsignedInteger('pangkat_id')->index();
            $table->unsignedInteger('jabatan_id')->index();
            // -----------------------------------

            // Data tambahan
            $table->enum('gol_darah', ['A', 'B', 'AB', 'O'])->default('A')->index();
            $table->enum('status_kawin', ['M', 'BM', 'CH', 'CM'])->default('BM')->index();
            $table->enum('status_pegawai', ['PPPK', 'PNS'])->default('PNS')->index();

            // Nomor identitas
            $table->string('no_kk', 20)->nullable()->index();
            $table->string('no_nik', 20)->nullable()->index();
            $table->string('no_bpjs', 20)->nullable()->index();
            $table->string('no_taspen', 20)->nullable()->index();

            // Dokumen
            $table->string('dok_kk', 150)->nullable();
            $table->string('dok_ktp', 150)->nullable();
            $table->string('dok_akte', 150)->nullable();
            $table->string('dok_nikah', 150)->nullable();

            $table->timestamps();

            // Foreign Key Constraint akan ditambahkan di migration terpisah
            // setelah semua tabel referensi dibuat
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pegawai');
    }
};
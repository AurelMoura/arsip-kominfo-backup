<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('riwayat_diklats', function (Blueprint $table) {
            $table->increments('id');
            // Relasi ke pegawai (NIP)
            $table->char('pegawai_id', 18)->index();
            
            $table->string('nama_diklat', 150);
            $table->string('penyelenggara', 150);
            $table->string('no_sertifikat', 100)->nullable();
            $table->year('tahun'); // Tipe data Year cocok untuk input "2020" dsb
            $table->string('dokumen', 150)->nullable(); // Untuk simpan path PDF sertifikat
            
            $table->timestamps();

            // Setup Foreign Key
            $table->foreign('pegawai_id')->references('id')->on('pegawai')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('riwayat_diklats');
    }
};
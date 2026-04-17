<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('riwayat_jabatans', function (Blueprint $table) {
            $table->increments('id');
            $table->char('pegawai_id', 18)->index(); // Foreign Key ke NIP Pegawai
            
            // Kolom ini nyambung ke tabel pangkats (sesuai permintaan kamu)
            $table->unsignedInteger('pangkat_id')->index(); 
            
            // Unit kerja sebagai foreign key
            $table->unsignedBigInteger('unit_kerja_id')->index();
            
            $table->date('tmt'); // Terhitung Mulai Tanggal
            $table->string('no_sk', 50);
            $table->string('dokumen', 150)->nullable(); // Path file SK Jabatan
            
            $table->timestamps();

            // Deklarasi Relasi
            $table->foreign('pegawai_id')->references('id')->on('pegawai')->onDelete('cascade');
            $table->foreign('pangkat_id')->references('id')->on('pangkats')->onDelete('cascade');
            $table->foreign('unit_kerja_id')->references('id')->on('unit_kerjas')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('riwayat_jabatans');
    }
};
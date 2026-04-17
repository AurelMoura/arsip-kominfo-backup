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
    Schema::create('penghargaans', function (Blueprint $table) {
        $table->increments('id');
        $table->char('pegawai_id', 18)->index();
        $table->string('nama_penghargaan', 100);
        $table->char('tahun', 4); // Sesuai Excel kamu pakai char 4
        $table->string('instansi_pemberi', 100);
        $table->string('dokumen', 150)->nullable(); // Path piagam/sertif
        $table->timestamps();

        $table->foreign('pegawai_id')->references('id')->on('pegawai')->onDelete('cascade');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penghargaans');
    }
};

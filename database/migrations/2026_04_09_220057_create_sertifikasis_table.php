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
    Schema::create('sertifikasis', function (Blueprint $table) {
        $table->increments('id');
        $table->char('pegawai_id', 18)->index();
        $table->string('nama_sertifikasi', 100);
        $table->integer('tahun'); 
        $table->string('lembaga_pelaksana', 100);
        $table->string('dokumen', 150)->nullable();
        $table->timestamps();

        $table->foreign('pegawai_id')->references('id')->on('pegawai')->onDelete('cascade');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sertifikasis');
    }
};

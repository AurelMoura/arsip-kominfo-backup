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
        if (!Schema::hasTable('riwayat_pendidikans')) {
            Schema::create('riwayat_pendidikans', function (Blueprint $table) {
                $table->increments('id');
                $table->char('pegawai_id', 18)->index();
                $table->unsignedInteger('pendidikan_id')->index();
                
                $table->string('nama_instansi', 100);
                $table->integer('tahun_masuk');
                $table->integer('tahun_keluar');
                $table->string('no_ijazah', 50);
                $table->string('nama_pejabat', 150);
                $table->string('dokumen', 150)->nullable();
                
                $table->timestamps();

                // Deklarasi Foreign Key
                $table->foreign('pegawai_id')->references('id')->on('pegawai')->onDelete('cascade');
                $table->foreign('pendidikan_id')->references('id')->on('pendidikans')->onDelete('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('riwayat_pendidikans');
    }
};
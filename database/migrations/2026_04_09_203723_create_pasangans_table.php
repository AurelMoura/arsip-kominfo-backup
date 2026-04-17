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
       Schema::create('pasangans', function (Blueprint $table) {
        $table->increments('id');
        // Harus CHAR 18 karena NIP di tabel pegawai kamu CHAR 18
        $table->char('pegawai_id', 18)->index(); 
        
        $table->string('nama', 100);
        $table->string('tempat_lahir', 50);
        $table->date('tanggal_lahir');
        $table->date('tanggal_nikah');
        $table->string('pekerjaan', 50)->nullable();
        
        $table->enum('aktif', ['Y', 'N'])->default('Y');
        $table->timestamps();

        // Relasi ke tabel pegawai
        $table->foreign('pegawai_id')->references('id')->on('pegawai')->onDelete('cascade');
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pasangans');
    }
};

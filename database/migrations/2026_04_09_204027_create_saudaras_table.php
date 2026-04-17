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
        Schema::create('saudaras', function (Blueprint $table) {
        $table->increments('id');
        $table->char('pegawai_id', 18)->index();
        
        $table->string('nama', 100);
        $table->enum('jenis_kelamin', ['L', 'P']);
        $table->string('tempat_lahir', 50);
        $table->date('tanggal_lahir');
        $table->string('pekerjaan', 50)->nullable();
        $table->string('status_hub', 50); // Kandung, Tiri, dll
        
        $table->enum('aktif', ['Y', 'N'])->default('Y');
        $table->timestamps();

        $table->foreign('pegawai_id')->references('id')->on('pegawai')->onDelete('cascade');
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('saudaras');
    }
};

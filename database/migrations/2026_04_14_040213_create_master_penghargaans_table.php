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
        Schema::create('master_penghargaans', function (Blueprint $table) {
            $table->id();
            $table->string('nama_penghargaan');
            $table->string('tahun')->nullable();
            $table->string('instansi_pemberi')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('master_penghargaans');
    }
};

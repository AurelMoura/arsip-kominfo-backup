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
        if (!Schema::hasTable('pendidikans')) {
            Schema::create('pendidikans', function (Blueprint $table) {
                // ID: int, PK, AI
                $table->increments('id'); 
                
                // Nama Pendidikan (SD, SMP, SMA, S1, dll)
                $table->string('nama', 50);
                
                // Status Aktif (Y/N)
                $table->enum('aktif', ['Y', 'N'])->default('Y')->index();
                
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pendidikans');
    }
};

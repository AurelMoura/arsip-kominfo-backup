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
        Schema::create('jabatans', function (Blueprint $table) {
            $table->increments('id'); 
            
            // Nama Jabatan (Isinya: Kepala Dinas, Kabid, dll)
            $table->string('nama', 50);

            // Eselon menggunakan ENUM karena pilihannya sudah pasti
            $table->enum('eselon', [
                'II/a', 'II/b', 
                'III/a', 'III/b', 
                'IV/a', 'IV/b', 
                'Fungsional', 
                'Non-Eselon'
            ])->nullable(); // nullable jika ada jabatan yang tidak punya eselon

            $table->enum('aktif', ['Y', 'N'])->default('Y')->index();
            $table->timestamps();   
                });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jabatans');
    }
};
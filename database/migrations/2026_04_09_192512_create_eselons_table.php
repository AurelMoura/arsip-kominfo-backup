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
        Schema::create('eselons', function (Blueprint $table) {
            // id: int, length 6, PK, AI
            // Kita pakai increments agar menghasilkan Unsigned Integer (cocok untuk FK)
            $table->increments('id'); 
            
            // nama: varchar, length 50
            $table->string('nama', 50);

            // eselon: enum (I, II, III, IV, JFT, JFU), default JFU, index
            $table->enum('eselon', ['I', 'II', 'III', 'IV', 'JFT', 'JFU'])
                  ->default('JFU')
                  ->index();

            // aktif: enum (Y, N), default Y, index
            $table->enum('aktif', ['Y', 'N'])
                  ->default('Y')
                  ->index();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('eselons');
    }
};
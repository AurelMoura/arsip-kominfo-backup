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
    Schema::create('pangkats', function (Blueprint $table) {
        $table->increments('id'); // PK, AI
        $table->string('nama', 50); // Contoh: Penata Muda
        $table->string('golongan', 10)->index(); // Contoh: III/a
        $table->enum('aktif', ['Y', 'N'])->default('Y')->index();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pangkats');
    }
};

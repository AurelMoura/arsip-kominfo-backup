<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('agama', function (Blueprint $table) {

            // Primary Key (Auto Increment)
            $table->id(); // setara dengan int, PK, AI

            // Nama agama
            $table->string('nama', 50); 

            // Status aktif
            $table->enum('aktif', ['Y', 'N'])->default('Y')->index();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('agama');
    }
};
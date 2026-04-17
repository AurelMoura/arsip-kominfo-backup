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
        Schema::table('pegawai', function (Blueprint $table) {
            $table->foreign('agama_id')->references('id')->on('agama');
            $table->foreign('pangkat_id')->references('id')->on('pangkats');
            $table->foreign('jabatan_id')->references('id')->on('jabatans');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pegawai', function (Blueprint $table) {
            $table->dropForeign(['agama_id']);
            $table->dropForeign(['pangkat_id']);
            $table->dropForeign(['jabatan_id']);
        });
    }
};

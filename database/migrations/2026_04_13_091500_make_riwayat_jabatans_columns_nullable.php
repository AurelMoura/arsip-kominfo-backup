<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('riwayat_jabatans', function (Blueprint $table) {
            $table->unsignedInteger('pangkat_id')->nullable()->change();
            $table->unsignedBigInteger('unit_kerja_id')->nullable()->change();
            $table->date('tmt')->nullable()->change();
            $table->string('no_sk', 50)->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('riwayat_jabatans', function (Blueprint $table) {
            $table->unsignedInteger('pangkat_id')->nullable(false)->change();
            $table->unsignedBigInteger('unit_kerja_id')->nullable(false)->change();
            $table->date('tmt')->nullable(false)->change();
            $table->string('no_sk', 50)->nullable(false)->change();
        });
    }
};

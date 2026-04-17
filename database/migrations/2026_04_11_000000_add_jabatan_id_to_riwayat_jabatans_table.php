<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('riwayat_jabatans', function (Blueprint $table) {
            if (!Schema::hasColumn('riwayat_jabatans', 'jabatan_id')) {
                $table->unsignedInteger('jabatan_id')->nullable()->after('pangkat_id')->index();
                $table->foreign('jabatan_id')->references('id')->on('jabatans')->onDelete('set null');
            }
        });
    }

    public function down(): void
    {
        Schema::table('riwayat_jabatans', function (Blueprint $table) {
            if (Schema::hasColumn('riwayat_jabatans', 'jabatan_id')) {
                $table->dropForeign(['jabatan_id']);
                $table->dropColumn('jabatan_id');
            }
        });
    }
};

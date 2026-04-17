<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('riwayat_jabatans', function (Blueprint $table) {
            if (!Schema::hasColumn('riwayat_jabatans', 'eselon_id')) {
                $table->unsignedInteger('eselon_id')->nullable()->after('jabatan_id')->index();
                $table->foreign('eselon_id')->references('id')->on('eselons')->onDelete('set null');
            }
        });
    }

    public function down(): void
    {
        Schema::table('riwayat_jabatans', function (Blueprint $table) {
            if (Schema::hasColumn('riwayat_jabatans', 'eselon_id')) {
                $table->dropForeign(['eselon_id']);
                $table->dropColumn('eselon_id');
            }
        });
    }
};
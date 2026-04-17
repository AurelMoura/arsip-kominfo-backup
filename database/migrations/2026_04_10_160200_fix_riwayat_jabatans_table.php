<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Drop kolom 'Unit kerja' jika ada
        if (Schema::hasColumn('riwayat_jabatans', 'Unit kerja')) {
            Schema::table('riwayat_jabatans', function (Blueprint $table) {
                $table->dropColumn('Unit kerja');
            });
        }

        // Pastikan kolom tmt dan no_sk bisa nullable
        Schema::table('riwayat_jabatans', function (Blueprint $table) {
            if (Schema::hasColumn('riwayat_jabatans', 'tmt')) {
                $table->date('tmt')->nullable()->change();
            }
            if (Schema::hasColumn('riwayat_jabatans', 'no_sk')) {
                $table->string('no_sk', 50)->nullable()->change();
            }
        });
    }

    public function down(): void
    {
        //
    }
};

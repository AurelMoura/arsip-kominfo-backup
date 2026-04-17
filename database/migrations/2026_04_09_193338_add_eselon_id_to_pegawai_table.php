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
            if (!Schema::hasColumn('pegawai', 'eselon_id')) {
                $table->unsignedInteger('eselon_id')->nullable()->after('jabatan_id');
                $table->foreign('eselon_id')->references('id')->on('eselons')->onDelete('set null');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pegawai', function (Blueprint $table) {
            if (Schema::hasColumn('pegawai', 'eselon_id')) {
                $table->dropForeign(['eselon_id']);
                $table->dropColumn('eselon_id');
            }
        });
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('riwayat_jabatans', function (Blueprint $table) {
            $table->string('jenis_jabatan')->nullable()->after('eselon_id');
            $table->string('nama_jabatan')->nullable()->after('jenis_jabatan');
            $table->string('eselon')->nullable()->after('nama_jabatan');
        });
    }

    public function down(): void
    {
        Schema::table('riwayat_jabatans', function (Blueprint $table) {
            $table->dropColumn(['jenis_jabatan', 'nama_jabatan', 'eselon']);
        });
    }
};

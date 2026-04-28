<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pegawai', function (Blueprint $table) {
            $table->boolean('is_locked_pendidikan')->default(false)->after('is_locked_keluarga');
            $table->boolean('is_locked_diklat')->default(false)->after('is_locked_pendidikan');
            $table->boolean('is_locked_jabatan')->default(false)->after('is_locked_diklat');
            $table->boolean('is_locked_penghargaan')->default(false)->after('is_locked_jabatan');
            $table->boolean('is_locked_sertifikasi')->default(false)->after('is_locked_penghargaan');
        });
    }

    public function down(): void
    {
        Schema::table('pegawai', function (Blueprint $table) {
            $table->dropColumn([
                'is_locked_pendidikan',
                'is_locked_diklat',
                'is_locked_jabatan',
                'is_locked_penghargaan',
                'is_locked_sertifikasi',
            ]);
        });
    }
};

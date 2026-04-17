<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pegawai', function (Blueprint $table) {
            $table->string('jabatan', 255)->nullable()->after('alamat');
            $table->string('eselon_jabatan', 100)->nullable()->after('jabatan');
            $table->string('golongan', 50)->nullable()->after('eselon_jabatan');
        });
    }

    public function down(): void
    {
        Schema::table('pegawai', function (Blueprint $table) {
            $table->dropColumn(['jabatan', 'eselon_jabatan', 'golongan']);
        });
    }
};
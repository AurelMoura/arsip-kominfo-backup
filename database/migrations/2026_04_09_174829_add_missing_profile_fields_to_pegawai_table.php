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
            if (!Schema::hasColumn('pegawai', 'email')) {
                $table->string('email')->nullable()->after('no_taspen');
            }
            if (!Schema::hasColumn('pegawai', 'alamat')) {
                $table->text('alamat')->nullable()->after('email');
            }
            if (!Schema::hasColumn('pegawai', 'kabupaten_asal')) {
                $table->string('kabupaten_asal')->nullable()->after('alamat');
            }
            if (!Schema::hasColumn('pegawai', 'no_hp')) {
                $table->string('no_hp')->nullable()->after('kabupaten_asal');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pegawai', function (Blueprint $table) {
            if (Schema::hasColumn('pegawai', 'email')) {
                $table->dropColumn('email');
            }
            if (Schema::hasColumn('pegawai', 'alamat')) {
                $table->dropColumn('alamat');
            }
            if (Schema::hasColumn('pegawai', 'kabupaten_asal')) {
                $table->dropColumn('kabupaten_asal');
            }
            if (Schema::hasColumn('pegawai', 'no_hp')) {
                $table->dropColumn('no_hp');
            }
        });
    }
};

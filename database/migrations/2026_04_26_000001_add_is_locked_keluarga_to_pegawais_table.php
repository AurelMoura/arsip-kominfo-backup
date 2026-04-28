<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('pegawais', function (Blueprint $table) {
            if (!Schema::hasColumn('pegawais', 'is_locked_keluarga')) {
                $table->boolean('is_locked_keluarga')->default(false)->after('data_keluarga');
            }
        });
    }

    public function down()
    {
        Schema::table('pegawais', function (Blueprint $table) {
            if (Schema::hasColumn('pegawais', 'is_locked_keluarga')) {
                $table->dropColumn('is_locked_keluarga');
            }
        });
    }
};

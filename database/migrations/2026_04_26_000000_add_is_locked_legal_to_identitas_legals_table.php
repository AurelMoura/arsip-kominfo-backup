<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('identitas_legals', function (Blueprint $table) {
            if (!Schema::hasColumn('identitas_legals', 'is_locked_legal')) {
                $table->boolean('is_locked_legal')->default(false)->after('dok_kk');
            }
        });
    }

    public function down()
    {
        Schema::table('identitas_legals', function (Blueprint $table) {
            if (Schema::hasColumn('identitas_legals', 'is_locked_legal')) {
                $table->dropColumn('is_locked_legal');
            }
        });
    }
};

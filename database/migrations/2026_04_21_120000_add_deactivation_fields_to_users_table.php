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
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'deactivation_reason')) {
                $table->string('deactivation_reason', 50)->nullable()->after('is_active');
            }

            if (!Schema::hasColumn('users', 'can_reactivate')) {
                $table->boolean('can_reactivate')->default(true)->after('deactivation_reason');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'can_reactivate')) {
                $table->dropColumn('can_reactivate');
            }

            if (Schema::hasColumn('users', 'deactivation_reason')) {
                $table->dropColumn('deactivation_reason');
            }
        });
    }
};
